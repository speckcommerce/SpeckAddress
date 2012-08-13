<?php
return array(

    'speckaddress' => array(
        'weighted_country_codes' => array(
            // higher weighted country codes will get a relevance multiplier for
            // the autocomplete plugin
            //
            // example:
            //'US' => 10,
            //'GB' => 10,
            //'DE' => 10,
        ),

        'alternate_spellings' => array(
            // some countries have various unofficial names and spellings
            // values are space-delimited
            //'US' => 'US USA United States of America',
            //'GB' => 'England Great Britain'
        ),
    ),

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
                                'action'     => 'add'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/edit',
                            'defaults' => array(
                                'controller' => 'speckaddress',
                                'action'     => 'edit',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'query' => array(
                                'type' => 'Query',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'controller' => 'speckaddress',
                                'action'     => 'delete',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'query' => array(
                                'type' => 'Query',
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
