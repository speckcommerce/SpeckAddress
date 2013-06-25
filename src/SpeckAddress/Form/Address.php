<?php

namespace SpeckAddress\Form;

use Zend\Form\Form;
use SpeckAddress\Options\ModuleOptions;

class Address extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Address Label'
            ),
        ));

        $this->add(array(
            'name' => 'street_address',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Street Address'
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'City'
            ),
        ));

        $this->add(array(
            'name' => 'country',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Country',
            ),
            'attributes' => array(
                'options' => array(),
            ),
        ));

        $this->add(array(
            'name' => 'province',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'State / Province'
            ),
            'attributes' => array(
                'options' => array(),
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Postal Code',
            ),
        ));
    }
}
