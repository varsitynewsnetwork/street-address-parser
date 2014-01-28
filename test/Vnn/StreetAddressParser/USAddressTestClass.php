<?php

namespace Vnn\StreetAddressParser;

class USAddressTestClass extends USAddress
{
    private $usaddr;

    public function __construct()
    {
        $this->usaddr = new USAddress();
    }

    public function parse($location, $informal = false)
    {
        return $this->usaddr->parse($location, $informal);
    }

    public function parse_intersection($inter)
    {
        return $this->usaddr->parse_intersection($inter);
    }

    public function parse_address($addr)
    {
        return $this->usaddr->parse_address($addr);
    }

    public function parse_informal_address($addr)
    {
        return $this->usaddr->parse_informal_address($addr);
    }

    public function street_type_regexp()
    {
        return $this->usaddr->street_type_regexp();
    }

    public function number_regexp()
    {
        return $this->usaddr->number_regexp();
    }

    public function fraction_regexp()
    {
        return $this->usaddr->fraction_regexp();
    }

    public function state_regexp()
    {
        return $this->usaddr->state_regexp();
    }

    public function city_and_state_regexp()
    {
        return $this->usaddr->city_and_state_regexp();
    }

    public function direct_regexp()
    {
        return $this->usaddr->direct_regexp();
    }

    public function zip_regexp()
    {
        return $this->usaddr->zip_regexp();
    }

    public function corner_regexp()
    {
        return $this->usaddr->corner_regexp();
    }

    public function unit_regexp()
    {
        return $this->usaddr->unit_regexp();
    }

    public function street_regexp()
    {
        return $this->usaddr->street_regexp();
    }

    public function place_regexp()
    {
        return $this->usaddr->place_regexp();
    }

    public function address_regexp()
    {
        return $this->usaddr->address_regexp();
    }

    public function informal_address_regexp()
    {
        return $this->usaddr->informal_address_regexp();
    }

}
