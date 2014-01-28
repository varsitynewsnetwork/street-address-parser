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

    public function getLine2Address()
    {
        return "";
    }

    private function is_intersection()
    {
        return !($this->street2 == null);
    }


    /**
     * Sets the value of street2.
     *
     * @param mixed $street2 the street2
     *
     * @return self
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Gets the value of street_type2.
     *
     * @return mixed
     */
    public function getStreet_type2()
    {
        return $this->street_type2;
    }

    /**
     * Sets the value of street_type2.
     *
     * @param mixed $street_type2 the street_type2
     *
     * @return self
     */
    public function setStreet_type2($street_type2)
    {
        $this->street_type2 = $street_type2;

        return $this;
    }

    /**
     * Gets the value of suffix2.
     *
     * @return mixed
     */
    public function getSuffix2()
    {
        return $this->suffix2;
    }

    /**
     * Sets the value of suffix2.
     *
     * @param mixed $suffix2 the suffix2
     *
     * @return self
     */
    public function setSuffix2($suffix2)
    {
        $this->suffix2 = $suffix2;

        return $this;
    }

    /**
     * Gets the value of prefix2.
     *
     * @return mixed
     */
    public function getPrefix2()
    {
        return $this->prefix2;
    }

    /**
     * Sets the value of prefix2.
     *
     * @param mixed $prefix2 the prefix2
     *
     * @return self
     */
    public function setPrefix2($prefix2)
    {
        $this->prefix2 = $prefix2;

        return $this;
    }

    public function getFullAddress1()
    {
        return $this->number." ".$this->prefix." ".$this->street." ".$this->street_type." ".$this->suffix;
    }

    public function getFullAddress2()
    {
        return $this->prefix2." ".$this->street2." ".$this->street_type2." ".$this->suffix2;
    }

}
