<?php

return array(
    'service_manager' => array(
        'aliases' => array(
            'speckaddress_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'speckaddress' => 'SpeckAddress\Controller\AddressController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'address' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/address[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[[a-zA-Z][a-zA-Z0-9_-]*]*',
                        'id'     => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller'    => 'speckaddress',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),

    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'SpeckAddress' => __DIR__ . '/../view',
        ),
    ),
);
