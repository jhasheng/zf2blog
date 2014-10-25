<?php
// use BjyProfiler\Db\Profiler\Profiler;
// use BjyProfiler\Db\Adapter\ProfilingAdapter;
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
//             'Zend\Db\Adapter\Adapter' => function ($sm) {
//                 $config = $sm->get('config');   //获取配置文件
//                 $adapter = new ProfilingAdapter($config['db']);
//                 $adapter->setProfiler(new Profiler());
//                 $adapter->injectProfilingStatementPrototype(array());
//                 return $adapter;
//             }
        )
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=zf2study;hostname=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    
//     'caches' => array(
//         'redis' => array(
//             'adapter' => array(
//                 'name' => 'redis',
//                 'lifetime' => 15,
//                 'options' => array(
//                     'server' => array(
//                         '10.10.10.68', 6379, 10
//                     )
//                 )
//             )
//         )
//     )
    
);
