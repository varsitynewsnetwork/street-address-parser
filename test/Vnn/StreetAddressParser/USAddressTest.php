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
        $us = new USAddress();

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
        $us = new USAddress();

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
        $us = new USAddress();

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
        $us = new USAddress();

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
        $us = new USAddress();

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
}
