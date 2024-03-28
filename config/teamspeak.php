<?php

declare(strict_types=1);

return [
    'host' => env('TEAMSPEAK_HOST', 'localhost'),
    'server_id' => (int)env('TEAMSPEAK_SERVER_ID', 1),
    'query_port' => (int)env('TEAMSPEAK_QUERY_PORT', 10011),
    'serverquery_login' => env('TEAMSPEAK_QUERY_USER', 'serveradmin'),
    'serverquery_password' => env('TEAMSPEAK_QUERY_PASSWORD', 'password'),
    'bot_nickname' => 'ts3-app > worker',
];
