<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BotServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->app->singleton('bot', static function () {
            return new \App\Services\BotService();
        });
    }
}
