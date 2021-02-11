<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * List all carriers with their countries sorted by a given schema
 */
echo "\n\n*** List all carriers with their countries sorted by a given schema: ";
echo "CountryMobileCarriers::listSortedCarriers(\$sortKeys, true);\n";
$sortKeys = array(
    "country",  // 1st key to sort on
    "name",     // 2nd key to sort on
    "mcc",      // 3rd key to sort on
    "mnc"       // 4th key to sort on
);
CountryMobileCarriers::listSortedCarriers($sortKeys, true);

/**
 * Get an array of carriers name and MCC/MNC for a given country
 */
echo "\n\n*** Get an array of carriers name and MCC/MNC for a given country: ";
echo "CountryMobileCarriers::getCountryCarriers('BE');\n";
print_r(CountryMobileCarriers::getCountryCarriers('BE'));

/**
 * List carriers name and MCC/MNC for a given country
 */
echo "\n\n*** List carriers name and MCC/MNC for a given country: ";
echo "CountryMobileCarriers::listCarriersOfCountry('MX');\n";
CountryMobileCarriers::listCarriersOfCountry('MX');

/**
 * List all MCC/MNC per carrier
 */
echo "\n\n*** List all MCC/MNC per carrier: ";
echo "CountryMobileCarriers::listAllMccMncPerCarrier();\n";
CountryMobileCarriers::listAllMccMncPerCarrier();

/**
 * Get an array of all MCC/MNC per carrier
 */
echo "\n\n*** Get all MCC/MNC per carrier: ";
echo "CountryMobileCarriers::getAllMccMncPerCarrier();\n";
print_r(CountryMobileCarriers::getAllMccMncPerCarrier());

/**
 * Get the alphabetically ordered list of all distinct carriers
 */
echo "\n\n*** Get the alphabetically ordered list of all distinct carriers: ";
echo "CountryMobileCarriers::getDistinctCarriers();\n";
print_r(CountryMobileCarriers::getDistinctCarriers());

/**
 * Get name of carrier matching a given mcc and mnc
 */
echo "\n\n*** Get name of carrier matching a given mcc and mnc: ";
echo "CountryMobileCarriers::getCarrierName('310', '850');\n";
echo CountryMobileCarriers::getCarrierName('310', '850') . PHP_EOL;

/**
 * Display MCC/MNC, country and name of carrier matching a given mcc and mnc
 */
echo "\n\n*** Display MCC/MNC, country and name of carrier matching a given mcc and mnc: ";
echo "CountryMobileCarriers::printCarrierName('310', '850');\n";
echo CountryMobileCarriers::printCarrierName('310', '850') . PHP_EOL;

/**
 * Print a list of MCC/MNC, country, name of all carriers having mcc or mnc matching a given key
 */
echo "\n\n*** Print a list of MCC/MNC, country, name of all carriers having mcc or mnc matching a given key: ";
echo "CountryMobileCarriers::listCarriersOfMccOrMnc(310);\n";
CountryMobileCarriers::listCarriersOfMccOrMnc(310);

/**
 * Print a list of MCC/MNC, country, name of all carriers matching a given mcc
 */
echo "\n\n*** Print a list of MCC/MNC, country, name of all carriers matching a given mcc: ";
echo "CountryMobileCarriers::listCarriersOfMcc(310);\n";
CountryMobileCarriers::listCarriersOfMcc(310);

/**
 * Print a list of MCC/MNC, country, name of all carriers matching a given mnc
 */
echo "\n\n*** Print a list of MCC/MNC, country, name of all carriers matching a given mnc: ";
echo "CountryMobileCarriers::listCarriersOfMnc(310);\n";
CountryMobileCarriers::listCarriersOfMnc(310);


/**
 * Export mcc-mnc and carrier name to TSV (e.g.: 310-800	T-Mobile)
 */
echo "\n\n*** Export mcc-mnc and carrier name to TSV: ";
echo "CountryMobileCarriers::export2tsv();\n";
CountryMobileCarriers::export2tsv();

