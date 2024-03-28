<?php

return [
    'name' => 'ts3-bot',
    'version' => app('git.version'),
    'author' => 'WebXScripts.ovh',
    'env' => 'development',
    'timezone' => 'UTC',
    'locale' => 'en',

    'providers' => [
        Illuminate\Translation\TranslationServiceProvider::class
    ],

    'use_dashboard' => env('USE_DASHBOARD', false),
];
