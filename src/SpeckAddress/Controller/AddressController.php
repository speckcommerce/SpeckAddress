<?php

namespace SpeckAddress\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

class AddressController extends AbstractActionController
{
    protected $addressService;
    protected $options;

    public function indexAction()
    {
        $addresses = $this->getAddressService()->getAddresses();
        return array('addresses' => $addresses);
    }

    public function addAction()
    {
        $form = $this->getAddForm();
        $prg = $this->prg('/address/add', true);

        $statuses = array();
        $namespaces = array('addr-add', 'addr-edit', 'addr-delete');
        foreach ($namespaces as $ns) {
            $fm = $this->flashMessenger()->setNamespace($ns)->getMessages();
            if (isset($fm[0])) {
                $statuses[$ns] = $fm[0];
            } else {
                $statuses[$ns] = null;
            }
        }

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form, 'statuses' => $statuses);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form, 'statuses' => $statuses);
        }

        // returns filtered input
        $filteredData = $form->getData();

        $this->getAddressService()->create($filteredData);
        $this->flashMessenger()->setNamespace('addr-add')->addMessage(true);
        return $this->redirect()->toRoute('address');
    }

    public function editAction()
    {
        $addressId = $this->params('id');
        $form = $this->getEditForm($addressId);

        return ['form' => $addressId];
    }

    public function deleteAction()
    {
        $addressId = $this->params('id');

        $this->getAddressService()->delete($addressId);
        $this->flashMessenger()->setNamespace('addr-delete')->addMessage(true);
        return $this->redirect()->toRoute('address');
    }

    public function getAddForm()
    {
        $form = $this->getServiceLocator()->get('SpeckAddress\Form\Address');
        $form->setInputFilter($this->getServiceLocator()->get('SpeckAddress\Form\AddressFilter'));
        return $form;
    }

    public function getEditForm()
    {
        $form = $this->getServiceLocator()->get('SpeckAddress\Form\EditAddress');
        $form->setInputFilter($this->getServiceLocator()->get('SpeckAddress\Form\AddressFilter'));

        //$addressService = $this->getAddressService();
        //$form->setAddress($addressService->findById($id));

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

    public function getOptions()
    {
        if (!isset($this->addressService)) {
            $this->options = $this->getServiceLocator()->get('SpeckAddress\Options\ModuleOptions');
        }

        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
