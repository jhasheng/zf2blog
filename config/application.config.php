<?php
return array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'JhaCore',
        'JhaAdmin',
//         'JhaBlog',
// 		'ZendDeveloperTools',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),

        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
//         'config_cache_enabled' => true,
//         'config_cache_key' => $stringKey,
//         'module_map_cache_enabled' => $booleanValue,
//         'module_map_cache_key' => $stringKey,
//         'cache_dir' => 'data/cache/',
        'check_dependencies' => true,
    ),

    //'service_listener_options' => array(
    //     array(
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ),
    // )

   // Initial configuration with which to seed the ServiceManager.
   // Should be compatible with Zend\ServiceManager\Config.
   // 'service_manager' => array(),
);
