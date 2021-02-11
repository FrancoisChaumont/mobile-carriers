<?php

const HIGHLIGHT_COLOR = "\033[36m";
const HIGHLIGHT_CLOSE = "\033[0m";

class CountryMobileCarriers {
    private static $_db = null;

    /**
     * Deserialize db from file and return it in an array
     *
     * @return array
     */
    public static function _getDB(): array {
        if (!self::$_db) {
            self::$_db = unserialize(file_get_contents(__DIR__."/db"));
        }
        return self::$_db;
    }

    /**
     * Extract carriers of a given country from the db and return the trimmed array
     *
     * @param string $country
     * @return array array containing mcc, mnc, name, country
     */
    public static function getCountryCarriers(string $country): array {
        $db = self::_getDB();
        $list = [];

        foreach($db as $carrier) {
            if ($carrier['country'] == $country) {
                $list[] = $carrier;
            }
        }

        return $list;
    }

    /**
     * Print a list of mcc, mnc, country, name of all carriers from the given country
     *
     * @param string $countryKey
     * @return void
     */
    public static function listCarriersOfCountry(string $countryKey): void {
        $db = self::_getDB();
        $list = '';

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        array_multisort($name, SORT_ASC, $mcc, SORT_ASC, $mnc, SORT_ASC, $country, SORT_ASC, $db);

        foreach($db as $carrier) {
            if (strtoupper($carrier['country']) == $countryKey) {
                $list .= sprintf("%s-%s\t[%s%s%s]\t%s\n", $carrier['mcc'], $carrier['mnc'], HIGHLIGHT_COLOR, $carrier['country'], HIGHLIGHT_CLOSE, $carrier['name']);
            }
        }

        print $list;
    }

    /**
     * Print a list of mcc, mnc, country, name of all carriers from the given mcc
     *
     * @param integer $mccKey
     * @return void
     */
    public static function listCarriersOfMcc(int $mccKey): void {
        $db = self::_getDB();
        $list = '';

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        array_multisort($mcc, SORT_ASC, $mnc, SORT_ASC, $name, SORT_ASC, $country, SORT_ASC, $db);

        foreach($db as $carrier) {
            if ($carrier['mcc'] == $mccKey) {
                $list .= sprintf("%s%s%s-%s\t[%s]\t%s\n", HIGHLIGHT_COLOR, $carrier['mcc'], HIGHLIGHT_CLOSE, $carrier['mnc'], $carrier['country'], $carrier['name']);
            }
        }

        print $list;
    }

    /**
     * Print a list of mcc, mnc, country, name of all carriers from the given mnc
     *
     * @param integer $mccKey
     * @return void
     */
    public static function listCarriersOfMnc(int $mncKey): void {
        $db = self::_getDB();
        $list = '';

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        array_multisort($mnc, SORT_ASC, $mcc, SORT_ASC, $name, SORT_ASC, $country, SORT_ASC, $db);

        foreach($db as $carrier) {
            if ($carrier['mnc'] == $mncKey) {
                $list .= sprintf("%s-%s%s%s\t[%s]\t%s\n", $carrier['mcc'], HIGHLIGHT_COLOR, $carrier['mnc'], HIGHLIGHT_CLOSE, $carrier['country'], $carrier['name']);
            }
        }

        print $list;
    }

    /**
     * Print a list of mcc, mnc, country, name of all carriers having a matching mcc or mnc to the given key
     *
     * @param integer $mccKey
     * @return void
     */
    public static function listCarriersOfMccOrMnc(int $key) {
        $db = self::_getDB();
        $list = '';

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        array_multisort($mcc, SORT_ASC, $mnc, SORT_ASC, $name, SORT_ASC, $country, SORT_ASC, $db);

        foreach($db as $carrier) {
            if ($carrier['mcc'] == $key) {
                $list .= sprintf("%s%s%s-%s\t[%s]\t%s\n", HIGHLIGHT_COLOR, $carrier['mcc'], HIGHLIGHT_CLOSE, $carrier['mnc'], $carrier['country'], $carrier['name']);
            }
            if ($carrier['mnc'] == $key) {
                $list .= sprintf("%s-%s%s%s\t[%s]\t%s\n", $carrier['mcc'], HIGHLIGHT_COLOR, $carrier['mnc'], HIGHLIGHT_CLOSE, $carrier['country'], $carrier['name']);
            }
        }

        print $list;
    }

    /**
     * Print a sorted list of all carriers along with their country, mcc and mnc
     *
     * @param array $sortKeys combination of the strings 'mcc', 'mnc', 'country', 'name' in whichever desired order ('name' = ascending sort, '-name' = descending sort)
     * @return void
     */
    public static function listSortedCarriers(array $sortKeys = array("mcc", "mnc", "country", "name"), $withHeaders = true) {
        $list = '';
        $db = self::_getDB();
        $green = "\033[32m";
        $red = "\033[31m";
        $close = HIGHLIGHT_CLOSE;

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        $sort = [];
        for ($i = 0, $imax = sizeof($sortKeys); $i < $imax; $i++) {
            $sortOrder = $sortKeys[$i][0] == '-' ? SORT_DESC : SORT_ASC;
            
            $sort[$i] = [
                str_replace('-', '', $sortKeys[$i]),
                $sortOrder
            ];

            $sortLabel = $sortOrder == SORT_ASC ? $green.($i+1).'˄'.$close : $red.($i+1).'˅'.$close;
            if ($sort[$i][0] == "mcc") { $mccOrder = $sortLabel; }
            elseif ($sort[$i][0] == "mnc") { $mncOrder = $sortLabel; }
            elseif ($sort[$i][0] == "country") { $countryOrder = $sortLabel; }
            elseif ($sort[$i][0] == "name") { $nameOrder = $sortLabel; }
        }

        if ($withHeaders) {
            $headers = sprintf("%s  %s\t%s  \t%s\n", $mccOrder, $mncOrder, $countryOrder, $nameOrder);
            $list .= $headers;
        }

        array_multisort(${$sort[0][0]}, $sort[0][1], ${$sort[1][0]}, $sort[1][1], ${$sort[2][0]}, $sort[2][1], ${$sort[3][0]}, $sort[3][1], $db);        

        foreach($db as $carrier) {
            $list .= sprintf("%s-%s\t[%s]\t%s\n", $carrier['mcc'], $carrier['mnc'], $carrier['country'], $carrier['name']);
        }
        
        if ($withHeaders) {
            $list .= $headers;
        }

        print $list;
    }

    /**
     * Get all carriers data from db
     *
     * @return array
     */
    private static function getAll(): array {
        return self::_getDB();
    }

    /**
     * Print name of carrier matching a given mcc and mnc
     *
     * @param string $mcc
     * @param string $mnc
     * @return void
     */
    public static function printCarrierName(string $mcc, string $mnc) {
        $db = self::_getDB();
        
        foreach ($db as $carrier) {
            if ($mcc == $carrier['mcc'] && $mnc == $carrier['mnc']) {
                print sprintf("%s%s%s-%s%s%s\t[%s]\t%s", HIGHLIGHT_COLOR, $carrier['mcc'], HIGHLIGHT_CLOSE, HIGHLIGHT_COLOR, $carrier['mnc'], HIGHLIGHT_CLOSE, $carrier['country'], $carrier['name']);
                return;
            }
        }

        print "Carrier not found!";
    }

    /**
     * Get name of carrier matching a given mcc and mnc
     *
     * @param string $mcc
     * @param string $mnc
     * @return string|null
     */
    public static function getCarrierName(string $mcc, string $mnc) {
        $db = self::_getDB();
        
        foreach ($db as $carrier) {
            if ($mcc == $carrier['mcc'] && $mnc == $carrier['mnc']) {
                return $carrier['name'];
            }
        }

        return '';
    }

    /**
     * Get the alphabetically ordered list of all distinct carriers found in the db
     *
     * @return array
     */
    public static function getDistinctCarriers(): array {
        $db = self::_getDB();
        $list = [];

        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);

        array_multisort($name, SORT_ASC, $db);

        foreach ($db as $carrier) {
            $name = $carrier['name'];
            if (array_search(strtolower($name), array_map('strtolower', $list)) === false) {
                $list[] = $name;
            }
        }

        return $list;
    }

    /**
     * Get all MCC/MNC per carrier
     *
     * @return array
     */
    public static function getAllMccMncPerCarrier(): array {
        $db = self::_getDB();
        $list = [];

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);

        array_multisort($name, SORT_ASC, $mcc, SORT_ASC, $mnc, SORT_ASC, $db);

        foreach ($db as $carrier) {
            $name = $carrier['name'];
            $list[$name][] = $carrier['mcc'] . "-" . $carrier['mnc'];
        }

        return $list;
    }

    /**
     * List all MCC/MNC per carrier
     *
     * @return void
     */
    public static function listAllMccMncPerCarrier(): void {
        $arr = self::getAllMccMncPerCarrier();
        $list = '';

        foreach ($arr as $key => $value) {
            $list .= "* " . $key . PHP_EOL;

            for ($i = 0, $imax = sizeof($value); $i < $imax; $i++) {
                $list .= "\t" . $value[$i] . PHP_EOL;
            }

            $list .= PHP_EOL;
        }

        print $list;
    }

    /**
     * Export mcc-mnc and carrier name to TSV (e.g.: 310-800	T-Mobile)
     *
     * @return void
     */
    public static function export2tsv(): void {
        $db = self::_getDB();
        $list = '';

        $mcc = array_column($db, 'mcc');
        $mnc = array_column($db, 'mnc');
        $name = array_column($db, 'name');
        $name = array_map('strtolower', $name);
        $country = array_column($db, 'country');

        array_multisort($mcc, SORT_ASC, $mnc, SORT_ASC, $country, SORT_ASC, $name, SORT_ASC, $db);

        foreach($db as $carrier) {
            $list .= sprintf("%s-%s\t%s\t%s\t%s\t%s\n", $carrier['mcc'], $carrier['mnc'], $carrier['mcc'], $carrier['mnc'], $carrier['country'], $carrier['name']);
        }

        print $list;

        // foreach (self::getAllMccMncPerCarrier() as $key => $value) {
        //     foreach ($value as $mccmnc) {
        //         echo "$mccmnc\t$key" . PHP_EOL;
        //     }
        // }
    }
}

