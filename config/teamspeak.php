<?php

declare(strict_types=1);

use App\Functions\OnJoin\WelcomeMessage;
use App\Functions\OnJoin\WelcomePoke;

return [
    'host' => env('TEAMSPEAK_HOST', 'localhost'),
    'server_id' => (int)env('TEAMSPEAK_SERVER_ID', 1),
    'query_port' => (int)env('TEAMSPEAK_QUERY_PORT', 10011),
    'serverquery_login' => env('TEAMSPEAK_QUERY_USER', 'serveradmin'),
    'serverquery_password' => env('TEAMSPEAK_QUERY_PASSWORD', 'password'),

    'bot_nickname' => 'ts3-app > worker',

    'functions' => [
        'interval' => [
            'server_name' => [
                'class' => App\Functions\Interval\ServerName::class,
                'enabled' => true,
                'interval' => 5,
            ],
        ],
        'on_join' => [
            'welcome_message' => [
                'class' => WelcomeMessage::class,
                'enabled' => true,
            ],
            'welcome_poke' => [
                'class' => WelcomePoke::class,
                'enabled' => true,
            ],
        ]
    ]
];
