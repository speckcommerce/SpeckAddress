<?php

namespace SpeckAddress\Mapper;

use ArrayObject;

use SpeckAddress\Entity\Address;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class AddressMapper extends AbstractDbMapper
{
    public function __construct()
    {
        // TODO set up entity prototype and hydrator
        $this->setEntityPrototype(new Address);
        $this->setHydrator(new ClassMethods);
    }

    public function getAddresses()
    {
        $select = new Select;
        $select->from('address');

        $resultSet = $this->selectWith($select);
        return $resultSet;
    }

    public function persist(Address $address)
    {
        if ($address->getAddressId() > 0) {
            $where = new Where;
            $where->equalTo('address_id', $address->getAddressId());

            $this->update($address, $where, 'address');
        } else {
            $result =$this->insert($address, 'address');
            $address->setAddressId($result->getGeneratedValue());
        }

        return $address;
    }

    public function getCountryList()
    {
        $select = new Select;
        $select->from('country_codes');

        $resultSet = $this->selectWith($select, new ArrayObject, new ArraySerializable);
        return $resultSet;
    }
}
