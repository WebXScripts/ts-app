<?php

return [
    'name' => 'ts3-bot',
    'version' => app('git.version'),
    'author' => 'WebXScripts.ovh',
    'env' => 'development',
    'timezone' => 'UTC',
    'locale' => 'en',
    'debug' => env('APP_DEBUG', false),

    'providers' => [
        Illuminate\Translation\TranslationServiceProvider::class,
        App\Providers\BotServiceProvider::class,
    ],

    'use_dashboard' => env('USE_DASHBOARD', false),
];
