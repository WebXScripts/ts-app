<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\BotException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BotService
{
    public function __construct(
        private ?string $uuid = null
    )
    {
    }

    public function generateUniqueId(): void
    {
        if (File::exists(storage_path('bot_uid'))) {
            $this->uuid = File::get(storage_path('bot_uid'));
            return;
        }

        $this->uuid = Str::uuid()->toString();
        File::append(storage_path('bot_uid'), $this->uuid);
    }

    public function sendPingToDashboard(): void
    {
        if ($this->uuid) {
            // Send statistics
            return;
        }

        throw new BotException('Bot UUID is not set.');
    }

    public function register(string $event, string|array $method): void
    {
        if (is_array($method)) {
            foreach ($method as $m) {
                $this->register($event, $m);
            }
            return;
        }

        $stored = Cache::get($event);

        if (class_exists($method) === false) {
            logger()->error("Class {$method} does not exist.");
            return;
        }

        Cache::put($event, $stored[] = new $method);
    }
}
