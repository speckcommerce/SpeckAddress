<?php

namespace SpeckAddress\Service;

use SpeckAddress\Entity\Address as AddressEntity;
use SpeckAddress\Service\AddressEvent;
use SpeckAddress\Mapper\AddressMapper;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class Address implements EventManagerAwareInterface
{
    protected $addressMapper;
    // added property
    protected $eventManager;
    protected $options;

    public function __construct()
    {
        $this->setEventManager(new EventManager());
    }

    public function findById($id)
    {
        // used method instead of property
        return $this->getAddressMapper()->findById($id);
    }

    /**
     * @param $address
     * @return AddressEntity
     */
    public function create($address)
    {
        $hydrated = $this->hydrate($address);

        $address = $this->getAddressMapper()->persist($hydrated);

        $events = $this->getEventManager();
        $events->trigger(AddressEvent::EVENT_ADD_ADDRESS_POST, $this, array('address' => $address));
        return $address;
    }

    public function update($address)
    {
        $hydrated = $this->hydrate($address);

        $this->getAddressMapper()->persist($hydrated);
    }

    public function delete($address)
    {
        if ($address instanceof AddressEntity) {
            $address = $address->getAddressId();
        }

        $this->getAddressMapper()->deleteAddress($address);
    }

    /**
     * @param $address
     * @return AddressEntity
     */
    protected function hydrate($address)
    {
        if (is_array($address)) {
            $hydrator = new ClassMethods;
            $address = $hydrator->hydrate($address, new AddressEntity);
        }
        return $address;
    }

    public function getAddresses()
    {
        return $this->getAddressMapper()->getAddresses();
    }

    public function getCountryList()
    {
        return $this->getAddressMapper()->getCountryList();
    }

    public function getProvinceList()
    {
        return $this->getAddressMapper()->getProvinceList();
    }

    /**
     * @return AddressMapper
     */
    public function getAddressMapper()
    {
        return $this->addressMapper;
    }

    public function setAddressMapper($addressMapper)
    {
        $this->addressMapper = $addressMapper;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            __CLASS__,
            get_called_class(),
            'speckaddress'
        );

        $eventManager->setEventClass('SpeckAddress\Service\AddressEvent');

        $this->eventManager = $eventManager;
        return $this;
    }
}
