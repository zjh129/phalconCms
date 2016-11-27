<?php
/**
 * Register application modules
 */
$application->registerModules(
    [
        'home'  => [
            'className' => 'MyApp\Modules\HomeModule',
            'path'      => APP_PATH . '/app/modules/HomeModule.php',
        ],
        'admin' => [
            'className' => 'MyApp\Modules\AdminModule',
            'path'      => APP_PATH . '/app/modules/AdminModule.php',
        ],
    ]
);
