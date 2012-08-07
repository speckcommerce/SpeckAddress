<?php

namespace SpeckAddress\Service;

use SpeckAddress\Entity\Address as AddressEntity;
use SpeckAddress\Service\AddressEvent;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class Address implements EventManagerAwareInterface
{
    protected $addressMapper;
    protected $options;

    public function __construct()
    {
        $this->setEventManager(new EventManager());
    }

    public function create($address)
    {
        if (is_array($address)) {
            $hydrator = new ClassMethods;
            $address = $hydrator->hydrate($address, new AddressEntity);
        }

        $this->addressMapper->persist($address);

        $events = $this->getEventManager();
        $events->trigger(AddressEvent::EVENT_ADD_ADDRESS_POST, $this, array('address' => $address));
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

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

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
