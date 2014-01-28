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

    /**
     * Returns the full address from parts composed of the public member variables. Complete addresses
     * would be returned in the format of:
     *
     * {number} {prefix} {street} {street_type} {unit_prefix} {unit} {suffix}, {city}, {state}, {postal_code}-{postal_code_ext}
     * or, for intersections:
     * {prefix} {street} {street_type} {suffix} and {prefix2} {street2} {street_type2} {suffix2}, {city}, {state}, {postal_code}
     *
     * @return string
     */
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

    /**
     * Returns the first line of a mailing address from parts composed of the public member variables. String
     * would be returned in the format of:
     *
     * {number} {prefix} {street} {street_type} {unit_prefix} {unit} {suffix}
     * or, for intersections:
     * {prefix} {street} {street_type} {suffix} and {prefix2} {street2} {street_type2} {suffix2}
     *
     * @return string
     */
    public function getLine1Address()
    {
        $ret = "";

        if ($this->is_intersection()) {
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

    /**
     * Currently returns nothing, because the parser cannot distinguish between line 1 addresses and other data
     * such as c/o, P.O. Box, etc. Will be updated as implementation is improved.
     *
     * @return string
     */
    public function getLine2Address()
    {
        return "";
    }

    private function is_intersection()
    {
        return !($this->street2 == null);
    }
}
