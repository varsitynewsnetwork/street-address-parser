<?php

namespace Vnn\StreetAddressParser;

/**
 * StreetAddressTest
 *
 * @group group
 */
class StreetAddressTest extends \PHPUnit_Framework_TestCase
{
    // Tests...
    public function testLine1()
    {
        $us = new USAddress();

        $addr = $us->parse("Hollywood & Vine, Los Angeles, Ca");
        $this->assertEquals("Hollywood and Vine", $addr->getLine1Address(), 'Get Street Address line1 failure for normalized intersection');

        $addr = $us->parse("West 51st and 7th, New York, New York 11220");
        $this->assertEquals("W 51st and 7th", $addr->getLine1Address(), 'Get Street Address line1 failure for prefixed intersection');

        $addr = $us->parse("750 W 26th St  Marion, IN 46953");
        $this->assertEquals("750 W 26th St", $addr->getLine1Address(), 'Get Street Address line1 failure for prefixed address');

        $addr = $us->parse("7337 Country Club Ln., West Chester, OH");
        $this->assertEquals("7337 Country Club Ln", $addr->getLine1Address(), 'Get Street Address line1 failure for non-prefixed address');
    }

    // Tests...
    public function testFullAddress()
    {
        $us = new USAddress();

        $addr = $us->parse("Hollywood & Vine, Los Angeles, Ca");
        $this->assertEquals("Hollywood and Vine, Los Angeles, CA", $addr->getFullAddress(), 'Get Street Address full failure for normalized intersection');

        $addr = $us->parse("West 51st and 7th, New York, New York 11220");
        $this->assertEquals("W 51st and 7th, New York, NY, 11220", $addr->getFullAddress(), 'Get Street Address full failure for prefixed intersection');

        $addr = $us->parse("750 W 26th St  Marion, IN 46953");
        $this->assertEquals("750 W 26th St, Marion, IN, 46953", $addr->getFullAddress(), 'Get Street Address full failure for prefixed address');

        $addr = $us->parse("7337 Country Club Ln., West Chester, OH");
        $this->assertEquals("7337 Country Club Ln, West Chester, OH", $addr->getFullAddress(), 'Get Street Address full failure for non-prefixed address');

        $addr = $us->parse("1 Rockafeller Plz, New York, New York, 10020-2003", true);
        $this->assertEquals("1 Rockafeller Plz, New York, NY, 10020-2003", $addr->getFullAddress(), 'Get Street Address full failure for informal address with zip+4');
    }
}
