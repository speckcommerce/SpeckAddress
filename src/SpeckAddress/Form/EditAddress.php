<?php

namespace SpeckAddress\Form;

use SpeckAddress\Entity\Address as AddressEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

class EditAddress extends Address
{
    public function init($moduleOptions)
    {
        parent::init($moduleOptions);

        $this->add(array(
            'name' => 'address_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
    }

    public function setAddress(AddressEntity $address)
    {
        $hydrator = new ClassMethods;
        $data = $hydrator->extract($address);

        $this->setData($data);
    }
}
