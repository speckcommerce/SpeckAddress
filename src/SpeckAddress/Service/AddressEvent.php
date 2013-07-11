<?php

namespace SpeckAddress\Service;

use SpeckAddress\Entity\AddressInterface;

use Zend\EventManager\Event;

class AddressEvent extends Event
{
    const EVENT_ADD_ADDRESS_POST = 'addAddress.post';

    public function setAddress(AddressInterface $address)
    {
        $this->setParam('address', $address);
        return $this;
    }

    public function getAddress()
    {
        return $this->getParam('address');
    }
}
