<?php
return array(
    'navigation' => array( // 参数区分大小写
        'default' => array(
            array(
                'label' => 'Overview',
                // 正确的路由匹配后自动active
                'route' => 'admin',
                'icon' => 'i i-statistics',
                'class' => 'auto'
            ),
            array(
                'label' => 'Posts',
                // 正确的路由匹配后自动active
                'route' => 'admin/post',
                'icon' => 'fa fa-archive',
                'class' => 'auto',
                'pages' => array(
                    array(
                        'label' => 'List',
                        'route' => 'admin/post/select',
                        'action' => 'index'
                    ),
                    array(
                        'label' => 'Add',
                        'route' => 'admin/post/select',
                        'action' => 'add',
                    ),
                )
            ),
            array(
                'label' => 'Comments',
                // 正确的路由匹配后自动active
                'route' => 'admin/comment',
                'icon' => 'fa fa-comment',
                'class' => 'auto',
                'pages' => array(
                    array(
                        'label' => 'List',
                        'route' => 'admin',
                        'controller' => 'comment',
                        'action' => 'index'
                    )
                )
            ),
            array(
                'label' => 'Category',
                // 正确的路由匹配后自动active
                'route' => 'admin',
                'controller' => 'category',
                'action' => 'index',
                'icon' => 'i i-menu2',
                'class' => 'auto'
            ),
            array(
                'label' => 'User',
                // 正确的路由匹配后自动active
                'route' => 'admin/user',
                'icon' => 'fa fa-user-md',
                'class' => 'auto',
                'pages' => array(
                    array(
                        'label' => 'List',
                        'route' => 'admin/user/operation',
                        'action' => 'index'
                    ),
                    array(
                        'label' => 'Groups',
                        'route' => 'admin/user/operation',
                        'action' => 'group'
                    ),
                    array(
                        'label' => 'Permission',
                        'route' => 'admin/user/operation',
                        'action' => 'permission'
                    )
                )
            ),
            array(
                'label' => 'Settings',
                // 正确的路由匹配后自动active
                'route' => 'admin/setting/select',
                'action' => 'index',
                'icon' => 'i i-settings',
                'class' => 'auto'
            ),
        )
    )
);