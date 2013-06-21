<?php

namespace SpeckAddress\Mapper;

use ArrayObject;

use SpeckAddress\Entity\Address;

use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
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

    public function findById($id)
    {
        $select = new Select;
        $select->from('address');

        $where = new Where;
        $where->equalTo('address_id', $id);

        $result = $this->select($select->where($where))->current();
        return $result;
    }

    public function getAddresses()
    {
        $select = new Select;
        $select->from('address');

        $resultSet = $this->select($select);
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

    public function deleteAddress($address)
    {
        $adapter = $this->getDbAdapter();
        $statement = $adapter->createStatement();

        $where = new Where;
        $where->equalTo('address_id', $address);

        $sql = new Delete;
        $sql->from('address')
            ->where($where);

        $sql->prepareStatement($adapter, $statement);
        $result = $statement->execute();
        return $result;
    }

    public function getCountryList()
    {
        $select = new Select;
        $select->from('country_codes');

        $resultSet = $this->select($select, new ArrayObject, new ArraySerializable);
        return $resultSet;
    }

    public function getProvinceList()
    {
        $select = new Select;
        $select->from('country_province');

        $resultSet = $this->select($select, new ArrayObject, new ArraySerializable);
        return $resultSet;
    }
}
