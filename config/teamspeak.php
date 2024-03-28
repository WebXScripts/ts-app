<?php

declare(strict_types=1);

use App\Functions\Interval\Clock;
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
                'interval' => 30,
            ],
            'clients_online' => [
                'class' => App\Functions\Interval\ClientsOnline::class,
                'enabled' => true,
                'interval' => 30,
                'channel_id' => 1,
            ],
            'clock' => [
                'class' => Clock::class,
                'enabled' => true,
                'interval' => 60,
                'channel_id' => 3,
                'format' => 'H:i'
            ]
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
