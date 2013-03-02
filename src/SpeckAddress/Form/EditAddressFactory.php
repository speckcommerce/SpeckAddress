<?php

namespace SpeckAddress\Form;

class EditAddressFactory extends AddressFactory
{
    public function getForm()
    {
        return new EditAddress();
    }
}
