<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'twig' => [
                'paths' => [
                    __DIR__ . '/../templates',
                ],
                // Twig environment options
                'options' => [
                    // Should be set to true in production
                    'cache_enabled' => false,
                    'cache_path' => __DIR__ . '/../tmp/twig',
                ],
            ],
            'db' => [
                'driver' => 'mysql',
                'host' => 'db',
                'database' => 'geofencing',
                'username' => 'root',
                'password' => 'root',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
        ],
    ]);
};
