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
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/address',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        'controller'    => 'speckaddress',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'controller' => 'speckaddress',
                                'action' => 'add'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'SpeckAddress' => __DIR__ . '/../view',
        ),
    ),
);
