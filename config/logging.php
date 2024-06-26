<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    'default' => env('LOG_CHANNEL', 'stack'),

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stderr', 'debug', 'error'],
            'ignore_exceptions' => false,
        ],

        'debug' => [
            'driver' => 'single',
            'path' => storage_path('logs/ts-app.debug.log'),
            'level' => 'debug',
        ],

        'error' => [
            'driver' => 'single',
            'path' => storage_path('logs/ts-app.error.log'),
            'level' => 'error',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

    ],
];
