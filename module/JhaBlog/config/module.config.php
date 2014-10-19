<?php
return array(
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        '__NAMESPACE__' => 'JhaBlog\Controller',
                        'controller'    => 'Blog',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/category/:catid]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'catid'     => '[1-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'priority' => 99
                    ),
                    'show' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[1-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'priority' => 99
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' =>array(
                            'route'    => '/[:controller[/:action[/page/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page'     => '[1-9]+',
                            ),
                        )
                    )
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'JhaBlog\Controller\Blog' => 'JhaBlog\Controller\BlogController',
            'JhaBlog\Controller\Comment' => 'JhaBlog\Controller\CommentController',
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'frontend/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'menu' => __DIR__.'/../view/partial/menu.phtml',
            'slide' => __DIR__.'/../view/partial/slide.phtml',
            'footer' => __DIR__.'/../view/partial/footer.phtml',
            'frontend/pagination' => __DIR__.'/../view/partial/pagination.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),

);