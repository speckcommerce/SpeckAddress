<?php

namespace SpeckAddress\Entity;

interface AddressInterface
{
    public function getAddressId();
    public function setAddressId($addressId);
    public function getName();
    public function setName($name);
    public function getStreetAddress();
    public function setStreetAddress($streetAddress);
    public function getCity();
    public function setCity($city);
    public function getProvince();
    public function setProvince($province);
    public function getPostalCode();
    public function setPostalCode($postalCode);
    public function getCountry();
    public function setCountry($country);
}
