<?php

namespace Vnn\StreetAddressParser;

class StreetAddress
{
    /**
     * number container
     *
     * @var number
     */
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
     * Gets the number container.
     *
     * @return number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number container.
     *
     * @param number $number the number
     *
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Gets the value of street.
     *
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the value of street.
     *
     * @param mixed $street the street
     *
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Gets the value of street_type.
     *
     * @return mixed
     */
    public function getStreet_type()
    {
        return $this->street_type;
    }

    /**
     * Sets the value of street_type.
     *
     * @param mixed $street_type the street_type
     *
     * @return self
     */
    public function setStreet_type($street_type)
    {
        $this->street_type = $street_type;

        return $this;
    }

    /**
     * Gets the value of unit.
     *
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Sets the value of unit.
     *
     * @param mixed $unit the unit
     *
     * @return self
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Gets the value of unit_prefix.
     *
     * @return mixed
     */
    public function getUnit_prefix()
    {
        return $this->unit_prefix;
    }

    /**
     * Sets the value of unit_prefix.
     *
     * @param mixed $unit_prefix the unit_prefix
     *
     * @return self
     */
    public function setUnit_prefix($unit_prefix)
    {
        $this->unit_prefix = $unit_prefix;

        return $this;
    }

    /**
     * Gets the value of suffix.
     *
     * @return mixed
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Sets the value of suffix.
     *
     * @param mixed $suffix the suffix
     *
     * @return self
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Gets the value of prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets the value of prefix.
     *
     * @param mixed $prefix the prefix
     *
     * @return self
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Gets the value of city.
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the value of city.
     *
     * @param mixed $city the city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets the value of state.
     *
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets the value of state.
     *
     * @param mixed $state the state
     *
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Gets the value of postal_code.
     *
     * @return mixed
     */
    public function getPostal_code()
    {
        return $this->postal_code;
    }

    /**
     * Sets the value of postal_code.
     *
     * @param mixed $postal_code the postal_code
     *
     * @return self
     */
    public function setPostal_code($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    /**
     * Gets the value of postal_code_ext.
     *
     * @return mixed
     */
    public function getPostal_code_ext()
    {
        return $this->postal_code_ext;
    }

    /**
     * Sets the value of postal_code_ext.
     *
     * @param mixed $postal_code_ext the postal_code_ext
     *
     * @return self
     */
    public function setPostal_code_ext($postal_code_ext)
    {
        $this->postal_code_ext = $postal_code_ext;

        return $this;
    }

    /**
     * Gets the value of street2.
     *
     * @return mixed
     */
    public function getStreet2()
    {
        return $this->street2;
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
}
