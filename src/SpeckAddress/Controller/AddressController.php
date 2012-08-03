<?php

namespace SpeckAddress\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

class AddressController extends AbstractActionController
{
    protected $addressService;

    public function indexAction()
    {
        $addresses = $this->getAddressService()->getAddresses();
        return array('addresses' => $addresses);
    }

    public function addAction()
    {
        $form = $this->getAddForm();
        $prg = $this->prg('address/add');

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form);
        }

        $this->getAddressService()->create($prg);
        return $this->redirect()->toRoute('address');
    }

    public function getAddForm()
    {
        $form = $this->getServiceLocator()->get('SpeckAddress\Form\Address');
        $form->setInputFilter($this->getServiceLocator()->get('SpeckAddress\Form\AddressFilter'));
        return $form;
    }

    public function getAddressService()
    {
        if (!isset($this->addressService)) {
            $this->addressService = $this->getServiceLocator()->get('SpeckAddress\Service\Address');
        }

        return $this->addressService;
    }

    public function setAddressService($addressService)
    {
        $this->addressService = $addressService;
        return $this;
    }
}
