<?php

namespace SpeckAddress\Form;

use Zend\InputFilter\InputFilter;

class AddressFilter extends InputFilter
{
    protected $adapter;
    // filters added
    protected $filter = array(
        array('name' => 'StripTags'),
        array('name' => 'StringTrim'),
    );
    // was set dynamically
    protected $countryProvinces;

    public function init()
    {
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => $this->filter,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 1,
                        'max' => 255
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'street_address',
            'required' => true,
            'filters' => $this->filter,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 400
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'required' => true,
            'filters' => $this->filter,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 5,
                        'max' => 255
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'country',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 2,
                        'max' => 2
                    ),
                ),
                array(
                    'name' => 'DbRecordExists',
                    'options' => array(
                        'table' => 'country_codes',
                        'field' => 'country_code',
                        'adapter' => $this->getAdapter()
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'province',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 5,
                        'max' => 6
                    ),
                ),
                array(
                    'name' => 'DbRecordExists',
                    'options' => array(
                        'table' => 'country_province',
                        'field' => 'country_province_code',
                        'adapter' => $this->getAdapter()
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'required' => false,
            'filters' => $this->filter,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 255
                    ),
                ),
            ),
        ));
    }


    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function getCountryProvinces()
    {
        return $this->countryProvinces;
    }

    public function setCountryProvinces($countryProvinces)
    {
        $this->countryProvinces = $countryProvinces;
        return $this;
    }
}
