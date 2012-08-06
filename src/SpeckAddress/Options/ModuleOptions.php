<?php

namespace SpeckAddress\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $__strictMode__ = false;

    protected $weightedCountryCodes = array();

    protected $alternateSpellings = array();

    public function getWeightedCountryCodes()
    {
        return $this->weightedCountryCodes;
    }

    public function setWeightedCountryCodes($weightedCountryCodes)
    {
        $this->weightedCountryCodes = $weightedCountryCodes;
        return $this;
    }

    public function getAlternateSpellings()
    {
        return $this->alternateSpellings;
    }

    public function setAlternateSpellings($alternateSpellings)
    {
        $this->alternateSpellings = $alternateSpellings;
        return $this;
    }
}
