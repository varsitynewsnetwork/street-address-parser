<?php

namespace Vnn\StreetAddressParser;

/**
 * USAddressTest
 *
 * @group group
 */
class USAddressTest extends \PHPUnit_Framework_TestCase
{
    // Tests...

    public function testStreet_type_regexp()
    {
        $us = new USAddressTestClass();

        // Positive tests for street types
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Street"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Road"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Way"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Drive"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Landing"));

        // These are negative tests for things that shouldn't match street type
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Garbage"));
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Arizona"));
    }

    public function testCity_and_state_regexp()
    {
        $us = new USAddressTestClass();

        // Positive tests for city, state
        $this->assertTrue(1 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Boston, MA"));
        $this->assertTrue(1 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Grand Rapids MI"));
        $this->assertTrue(1 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Los Angeles, CA"));
        $this->assertTrue(1 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Tuscon, Arizona"));
        $this->assertTrue(1 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Flint Michigan"));

        // Negative tests (no city, fake state)
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Fake State"));
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Arizona"));
    }

    public function testDirect_regexp()
    {
        $us = new USAddressTestClass();

        // Positive tests for directions
        $this->assertTrue(1 == preg_match("/" . $us->direct_regexp() . "/ix", "Northeast"));
        $this->assertTrue(1 == preg_match("/" . $us->direct_regexp() . "/ix", "SW"));
        $this->assertTrue(1 == preg_match("/" . $us->direct_regexp() . "/ix", "N.W."));
        $this->assertTrue(1 == preg_match("/" . $us->direct_regexp() . "/ix", "Northern")); //NORTHern will match

        // Negative tests for directions (hard to come up with a no-match because N,S,E,W in the word at all will match
        $this->assertTrue(0 == preg_match("/" . $us->direct_regexp() . "/ix", "TX"));
    }

    public function testStreet_regexp()
    {
        $us = new USAddressTestClass();

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "1600 Pennsylvania Avenue", $matches);
        $this->assertEquals("1600 Pennsylvania Avenue", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "1101 Northeast Spruce Lane", $matches);
        $this->assertEquals("1101 Northeast Spruce Lane", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "201 Monroe Ave NW", $matches);
        $this->assertEquals("201 Monroe Ave NW", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "3378 Kimberly Drive", $matches);
        $this->assertEquals("3378 Kimberly Drive", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "1503 Ridgewood Road", $matches);
        $this->assertEquals("1503 Ridgewood Road", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->street_regexp() . "/ix", "Garbage 17haj67 Alasd", $matches);
        $this->assertNotEquals("Garbage 17haj67 Alasd", $matches[0], 'Garbage Address should not match street regexp');
    }

    public function testPlace_regexp()
    {
        $us = new USAddressTestClass();

        // Positive Test Cases
        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Zeeland, MI 49464", $matches);
        $this->assertEquals("Zeeland, MI 49464", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Cedar Springs, MI 49319", $matches);
        $this->assertEquals("Cedar Springs, MI 49319", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Fairborn, Ohio, 45324", $matches);
        $this->assertEquals("Fairborn, Ohio, 45324", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Bay City, MI", $matches);
        $this->assertEquals("Bay City, MI", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Mt. Pleasant, MI", $matches);
        $this->assertEquals("Mt. Pleasant, MI", $matches[0], 'Complete address did not match street regexp');

        // Negative Test Cases
        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "1503 Ridgewood Road", $matches);
        $this->assertNotEquals("1503 Ridgewood Road", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->place_regexp() . "/ix", "Ann Arbor, MU 44332", $matches);
        $this->assertNotEquals("Ann Arbor, MU 44332", $matches[0], 'Complete address did not match street regexp');

    }

    public function testAddress_regexp()
    {
        $us = new USAddressTestClass();

        // Positive Test Cases (valid addresses)
        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "400 W. Dublin-Granville Rd., Worthington, OH 43085", $matches);
        $this->assertEquals("400 W. Dublin-Granville Rd., Worthington, OH 43085", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "7337 Country Club Ln., West Chester, OH", $matches);
        $this->assertEquals("7337 Country Club Ln., West Chester, OH", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "6383 Glenway Ave, Cincinnati, OH 45211", $matches);
        $this->assertEquals("6383 Glenway Ave, Cincinnati, OH 45211", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "600 West North Bend Road, Cincinnati, OH 45224", $matches);
        $this->assertEquals("600 West North Bend Road, Cincinnati, OH 45224", $matches[0], 'Complete address did not match street regexp');

        // Negative Test Cases (cannot parse data in front of a full address, or address without specific number information)
        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "Western Bowl, 6383 Glenway Ave, Cincinnati, OH 45211", $matches);
        $this->assertNotEquals("Western Bowl, 6383 Glenway Ave, Cincinnati, OH 45211", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "The Meadows Golf Club", $matches);
        $this->assertNotEquals("The Meadows Golf Club", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "St. Xavier High School, 1609 Poplar Level Rd, Louisville, KY", $matches);
        $this->assertNotEquals("St. Xavier High School, 1609 Poplar Level Rd, Louisville, KY", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->address_regexp() . "/ix", "Glenway Ave, Cincinnati, OH 45211", $matches);
        $this->assertNotEquals("Glenway Ave, Cincinnati, OH 45211", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

    }

    public function testInformal_address_regexp()
    {
        $us = new USAddressTestClass();

        // Positive Test Cases (valid addresses)
        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "400 W. Dublin-Granville Rd., Worthington, OH 43085", $matches);
        $this->assertEquals("400 W. Dublin-Granville Rd., Worthington, OH 43085", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "7337 Country Club Ln., West Chester, OH", $matches);
        $this->assertEquals("7337 Country Club Ln., West Chester, OH", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "600 West North Bend Road, Cincinnati, OH 45224", $matches);
        $this->assertEquals("600 West North Bend Road, Cincinnati, OH 45224", $matches[0], 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "600 West North Bend Road, Cincinnati, OH", $matches);
        $this->assertEquals("600 West North Bend Road, Cincinnati, OH", $matches[0], 'Complete address did not match street regexp');

        // Negative Test Cases (cannot parse data in front of a full address, or an address without specific number information)
        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "Glenway Ave, Cincinnati, OH 45211", $matches);
        $this->assertNotEquals("Glenway Ave, Cincinnati, OH 45211", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "Western Bowl, 6383 Glenway Ave, Cincinnati, OH 45211", $matches);
        $this->assertNotEquals("Western Bowl, 6383 Glenway Ave, Cincinnati, OH 45211", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "The Meadows Golf Club", $matches);
        $this->assertNotEquals("The Meadows Golf Club", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');

        $matches = array();
        preg_match("/" . $us->informal_address_regexp() . "/ix", "St. Xavier High School, 1609 Poplar Level Rd, Louisville, KY", $matches);
        $this->assertNotEquals("St. Xavier High School, 1609 Poplar Level Rd, Louisville, KY", isset($matches[0]) ? $matches[0] : NULL, 'Complete address did not match street regexp');
    }

    public function testParse_intersection()
    {
        $us = new USAddressTestClass();

        $addr = $us->parse_intersection("Hollywood & Vine, Los Angeles, Ca");
        $this->assertEquals("Los Angeles", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("CA", $addr->state, 'City does not match expected for intersection parsing');

        $addr = $us->parse_intersection("West 51st and 7th, New York, NY 11220");
        $this->assertEquals("51st", $addr->street, 'City does not match expected for intersection parsing');
        $this->assertEquals("7th", $addr->street2, 'City does not match expected for intersection parsing');
        $this->assertEquals("New York", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("NY", $addr->state, 'City does not match expected for intersection parsing');
        $this->assertEquals("11220", $addr->postal_code, 'City does not match expected for intersection parsing');
    }

    public function testParse()
    {
        $us = new USAddressTestClass();

        $addr = $us->parse("Hollywood & Vine, Los Angeles, Ca");
        $this->assertEquals("Los Angeles", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("CA", $addr->state, 'City does not match expected for intersection parsing');

        $addr = $us->parse("West 51st and 7th, New York, New York 11220");
        $this->assertEquals("51st", $addr->street, 'City does not match expected for intersection parsing');
        $this->assertEquals("7th", $addr->street2, 'City does not match expected for intersection parsing');
        $this->assertEquals("New York", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("NY", $addr->state, 'City does not match expected for intersection parsing');
        $this->assertEquals("11220", $addr->postal_code, 'City does not match expected for intersection parsing');

        $addr = $us->parse("750 W 26th St  Marion, IN 46953");
        $this->assertEquals("26th", $addr->street, 'City does not match expected for intersection parsing');
        $this->assertEquals("Marion", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("IN", $addr->state, 'City does not match expected for intersection parsing');
        $this->assertEquals("46953", $addr->postal_code, 'City does not match expected for intersection parsing');

<<<<<<< HEAD
        $addr = $us->parse("3200 W Tienken Rd, Rochester, MI");
        $this->assertEquals("Tienken", $addr->street, 'City does not match expected for intersection parsing');
        $this->assertEquals("Rochester", $addr->city, 'City does not match expected for intersection parsing');
        $this->assertEquals("MI", $addr->state, 'City does not match expected for intersection parsing');
       

    }

    public function testGooglePlacesAddress()
    {
        $address = '3200 W Tienken Rd, Rochester, MI, United States';

=======
        $addr = $us->parse("1600 Pennsylvania Ave");
        $this->assertEquals(null,$addr, "Incomplete address should not be parsed unless informal = true");

        $addr = $us->parse("1600 Pennsylvania Avenue", true);
        $this->assertEquals("1600",$addr->number, "Street number not parsed even though informal was true");
        $this->assertEquals("Pennsylvania",$addr->street, "Street not parsed even though informal was true");
        $this->assertEquals("Ave",$addr->street_type, "Street type not parsed, and normalized, even though informal was true");
>>>>>>> 9fb5d4553ea938699aa54de6f95e2195c3027a11
    }
}
