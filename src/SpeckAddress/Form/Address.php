<?php

namespace SpeckAddress\Form;

use Zend\Form\Form;

class Address extends Form
{
    protected $addressService;

    public function init($moduleOptions)
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Address Label'
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'street_address',
            'options' => array(
                'label' => 'Street Address'
            ),
            'attributes' => array(
                'type' => 'textarea'
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'options' => array(
                'label' => 'City'
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'province',
            'options' => array(
                'label' => 'State / Province'
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'options' => array(
                'label' => 'Postal Code',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'country',
            'options' => array(
                'label' => 'Country',
            ),
            'attributes' => array(
                'type' => 'select',
                'options' => $this->getCountryOptions($moduleOptions),
            ),
        ));
    }

    public function getCountryOptions($moduleOptions = array())
    {
        $countries = $this->getAddressService()->getCountryList();

        $weights = $moduleOptions->getWeightedCountryCodes();
        $spelling = $moduleOptions->getAlternateSpellings();

        $result = array();
        $result[""] = "";
        foreach ($countries as $c) {
            $result[] = array(
                'label' => utf8_encode($c['country']),
                'value' => $c['country_code'],
                'weight' => isset($weights[$c['country_code']]) ? $weights[$c['country_code']] : 1,
                'alt-spelling' => isset($spelling[$c['country_code']]) ? $spelling[$c['country_code']] : '',
            );
        }

        return $result;
    }

    public function getAddressService()
    {
        return $this->addressService;
    }

    public function setAddressService($addressService)
    {
        $this->addressService = $addressService;
        return $this;
    }
}
