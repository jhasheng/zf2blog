<?php
return array(
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/auth[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'JhaCore\Controller',
                        'controller' => 'Auth',
                        'action' => 'login'
                    )
                ),
                'may_terminate' => true
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'JhaCore\Controller\Auth' => 'JhaCore\Controller\AuthController',
        ),
    ),
    
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'layout/auth'             => __DIR__ . '/../view/layout/auth.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'auth' => array(
        'storage' => 'session',
        'table' => 'user',
    	'username' => 'username',
        'password' => 'password',
        'passwordtype' => 'md5(?)'
    )
);