<?php

declare(strict_types=1);

return [
    'interval' => [
        'app_information' => [
            'class' => App\Functions\Interval\AppInformation::class,
            'enabled' => true,
            'interval' => 60 * 5,
            'channel_id' => 4,
        ],
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
            'class' => App\Functions\Interval\Clock::class,
            'enabled' => true,
            'interval' => 60,
            'channel_id' => 3,
            'format' => 'H:i'
        ]
    ],
    'on_join' => [
        'welcome_message' => [
            'class' => App\Functions\OnJoin\WelcomeMessage::class,
            'enabled' => true,
        ],
        'welcome_poke' => [
            'class' => App\Functions\OnJoin\WelcomePoke::class,
            'enabled' => true,
        ],
    ]
];
