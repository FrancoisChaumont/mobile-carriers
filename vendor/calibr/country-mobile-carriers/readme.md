## Returns list of mobile carriers for specific country

### Install

`composer require calibr/country-mobile-carriers`

### Usage

```php

$carriers = CountryMobileCarriers::getList("RU");

/**
 * carriers array will look like this:
 * [
 *   [
 *     "name" => "Baykal Westcom",
 *     "mcc" => 250,
 *     "mnc" => 12
 *   ],
 *   ...
 * ]
 */

// returns whole database as array, key is country code, value is list of carriers
// in same format as in getList
$allCarriers = CountryMobileCarriers::getAll();

```

Database is taken from http://mcc-mnc.com/.