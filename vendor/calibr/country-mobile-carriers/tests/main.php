<?php

require "./CountryMobileCarriers.php";

class CountryMobileCarriersTest extends PHPUnit_Framework_TestCase
{
  public function testGetList() {
    $carriers = CountryMobileCarriers::getList("RU");
    $carrier = $carriers[0];
    var_dump($carrier);
    $this->assertInternalType("string", $carrier["name"]);
    $this->assertInternalType("int", $carrier["mcc"]);
    $this->assertInternalType("int", $carrier["mnc"]);
    $this->assertCount(22, $carriers);
  }
}