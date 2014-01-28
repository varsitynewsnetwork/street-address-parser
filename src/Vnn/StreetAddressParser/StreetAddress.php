<?php

namespace Vnn\StreetAddressParser;

class StreetAddress
{
    public $number;
    public $street;
    public $street_type;
    public $unit;
    public $unit_prefix;
    public $suffix;
    public $prefix;
    public $city;
    public $state;
    public $postal_code;
    public $postal_code_ext;
    public $street2;
    public $street_type2;
    public $suffix2;
    public $prefix2;

    public function getFullAddress()
    {
        $ret = $this->getLine1Address();
        $ret .= !empty($this->city) ? (", " . $this->city) : "";
        $ret .= !empty($this->state) ? (", " . $this->state) : "";
        $ret .= !empty($this->postal_code) ? (", " . $this->postal_code) : "";

        if (!$this->is_intersection())
            $ret .= !empty($this->postal_code_ext) ? ("-" . $this->postal_code_ext) : "";

        return $ret;
    }

    public function getLine1Address()
    {
        $ret = "";

        if ($this->is_intersection()){
            $ret .= !empty($this->prefix) ? ($this->prefix . " ") : "";
            $ret .= $this->street;
            $ret .= !empty($this->street_type) ? (" " . $this->street_type) : "";
            $ret .= !empty($this->suffix) ? (" " . $this->suffix) : "";
            $ret .= " and";

            $ret .= !empty($this->prefix2) ? (" " . $this->prefix2) : "";
            $ret .= " " . $this->street2;
            $ret .= !empty($this->street_type2) ? (" " . $this->street_type2) : "";
            $ret .= !empty($this->suffix2) ? (" " . $this->suffix2) : "";
        } else {
            $ret .= $this->number;
            $ret .= !empty($this->prefix) ? (" " . $this->prefix) : "";
            $ret .= !empty($this->street) ? (" " . $this->street) : "";
            $ret .= !empty($this->street_type) ? (" " . $this->street_type) : "";

            if (!empty($this->unit_prefix) && !empty($this->unit)) {
                $ret .= " " . $this->unit_prefix;
                $ret .= " " . $this->unit;
            } elseif ( empty($this->unit_prefix) && !empty($this->unit)) {
                $ret .= " " . $this->unit;
            }
            $ret .= !empty($this->suffix) ? (" " . $this->suffix) : "";
        }

        return $ret;
    }

    private function is_intersection()
    {
        return !($this->street2 == null);
    }


}
