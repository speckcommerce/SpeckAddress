<?php

namespace SpeckAddress\Service;

use SpeckAddress\Entity\Address as AddressEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

class Address
{
    protected $addressMapper;

    public function create($address)
    {
        if (is_array($address)) {
            $hydrator = new ClassMethods;
            $address = $hydrator->hydrate($address, new AddressEntity);
        }

        $this->addressMapper->persist($address);
    }

    public function getAddresses()
    {
        return $this->addressMapper->getAddresses();
    }

    public function getCountryList()
    {
        return $this->addressMapper->getCountryList();
    }

    public function getAddressMapper()
    {
        return $this->addressMapper;
    }

    public function setAddressMapper($addressMapper)
    {
        $this->addressMapper = $addressMapper;
        return $this;
    }
}
