<?php

declare(strict_types=1);

return [
    'on_client_join' => [
        \App\Functions\OnJoin\WelcomeMessage::class,
    ],
    /*
    'interval' => [
        'app_information' => [
            'class' => App\Functions\Interval\AppInformation::class,
            'enabled' => true,
            'interval' => 5,
            'channel_id' => 4,
        ],
        'server_name' => [
            'class' => App\Functions\Interval\ServerName::class,
            'enabled' => true,
            'interval' => 60,
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
        ],
        'user_guard' => [
            'class' => App\Functions\Interval\UserGuard::class,
            'enabled' => true,
            'interval' => 15,
            'check_nickname' => true,
            'check_description' => true,
            'punishment' => 'kick', // 'kick' or 'ban'
            'ban_time' => 60,
            'bad_words' => [
                'admin',
                'moderator',
                'serverquery',
            ]
        ],
        'chat_advertising' => [
            'class' => App\Functions\Interval\ChatAdvertising::class,
            'enabled' => false,
            'interval' => 15,
            'ignored_groups' => [],
            'messages' => [
                'Visit our website: your-website.com',
                'Visit our forum: your-forum.com',
            ]
        ],
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
        'nickname_checker' => [
            'class' => App\Functions\OnJoin\NicknameChecker::class,
            'enabled' => true,
            'punishment' => 'ban', // 'kick' or 'ban'
            'ban_time' => 60,
            'bad_nicknames' => [
                'ServerQuery',
                'admin',
                'moderator',
            ]
        ],
    ]
    */
];
