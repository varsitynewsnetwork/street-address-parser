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

        // Positive tests for street address
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Street"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Road"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Way"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Drive"));
        $this->assertTrue(1 == preg_match("/" . $us->street_type_regexp() . "/ix", "Landing"));

        // These are negative tests for just states
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Garbage NoState"));
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

        // These are negative tests for just states
        $this->assertTrue(0 == preg_match("/" . $us->city_and_state_regexp() . "/ix", "Garbage NoState"));
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
}
