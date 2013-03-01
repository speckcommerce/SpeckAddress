<?php

namespace SpeckAddress;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    public function getServiceConfig()
    {
        return array(
            'shared' => array(
                'SpeckAddress\Form\Address'       => false,
                'SpeckAddress\Form\EditAddress'   => false,
                'SpeckAddress\Form\AddressFilter' => false,
            ),
            'factories' => array(
                'SpeckAddress\Form\Address' => function($sm) {
                    $form = new Form\Address;
                    $form->setAddressService($sm->get('SpeckAddress\Service\Address'));

                    $options = $sm->get('SpeckAddress\Options\ModuleOptions');
                    $form->setModuleOptions($options);

                    return $form;
                },

                'SpeckAddress\Form\EditAddress' => function($sm) {
                    $form = new Form\EditAddress;
                    $form->setAddressService($sm->get('SpeckAddress\Service\Address'));

                    $options = $sm->get('SpeckAddress\Options\ModuleOptions');
                    $form->setModuleOptions($options);

                    return $form;
                },

                'SpeckAddress\Service\Address' => function($sm) {
                    $service = new Service\Address;
                    $service->setAddressMapper($sm->get('SpeckAddress\Mapper\AddressMapper'));
                    $service->setOptions($sm->get('SpeckAddress\Options\ModuleOptions'));

                    return $service;
                },

                'SpeckAddress\Options\ModuleOptions' => function($sm) {
                    $config = $sm->get('Configuration');
                    $moduleConfig = isset($config['speckaddress']) ? $config['speckaddress'] : array();
                    return new Options\ModuleOptions($moduleConfig);
                },

                'SpeckAddress\Mapper\AddressMapper' => function($sm) {
                    $mapper = new Mapper\AddressMapper;
                    $mapper->setDbAdapter($sm->get('speckaddress_db_adapter'));
                    return $mapper;
                },

                'SpeckAddress\Form\AddressFilter' => function($sm) {
                    $filter = new Form\AddressFilter;
                    $filter->setAdapter($sm->get('speckaddress_db_adapter'));
                    $filter->init();
                    return $filter;
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'speckSelect' => 'SpeckAddress\Form\View\Helper\FormSelect',
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
