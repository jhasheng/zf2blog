<?php
return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'JhaAdmin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'post' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/post',
                            'defaults' => array(
                                'controller'    => 'Post',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'select' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:action[/:page]',
                                    'constraints' => array(
                                        'action' => '(index|add)',
                                        'page' => '[1-9][0-9]*',
                                    )
                                ),
                                'may_terminate' => true,
                            ),

                            'operation' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '(edit|delete|undo|trash)',
                                        'id' => '[1-9][0-9]*'
                                    ),
                                )
                            )
                        )
                    ),
                    'comment' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/comment',
                            'defaults' => array(
                                'controller' => 'Comment',
                            ),
                        ),
                        'may_terminate' => true
                    ),
                    'user' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/user',
                            'defaults' => array(
                                'controller' => 'User',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'operation' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:action',
                                    'constraints' => array(
                                        'action' => '(index|group|permission)',
                                    ),
                                )
                            )
                        )
                    ),
                    'setting' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/setting',
                            'defaults' => array(
                                'controller' => 'Setting',
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'select' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:action',
                                    'constraints' => array(
                                        'action' => '(index|add)'
                                    )
                                )
                            ),
                            'operation' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:action/:id',
                                    'constraints' => array(
                                        'action' => '(edit|delete|undo|trash)',
                                        'id' => '[1-9][0-9]*'
                                    ),
                                )
                            )
                        )
                    )
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'JhaAdmin\Controller\Index'     => 'JhaAdmin\Controller\IndexController',
            'JhaAdmin\Controller\Post'      => 'JhaAdmin\Controller\PostController',
            'JhaAdmin\Controller\User'      => 'JhaAdmin\Controller\UserController',
            'JhaAdmin\Controller\Category'  => 'JhaAdmin\Controller\CategoryController',
            'JhaAdmin\Controller\Comment'   => 'JhaAdmin\Controller\CommentController',
            'JhaAdmin\Controller\Setting'   => 'JhaAdmin\Controller\SettingController',
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/error'            => __DIR__ . '/../view/layout/error.phtml',
            'admin/index/index'       => __DIR__ . '/../view/admin/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'header'                  => __DIR__ . '/../view/partial/header.phtml',
            'navigation'              => __DIR__ . '/../view/partial/navigation.phtml',
            'breadcrumb'              => __DIR__ . '/../view/partial/breadcrumb.phtml',
            'backend/pagination'      => __DIR__ . '/../view/partial/pagination.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),

);
