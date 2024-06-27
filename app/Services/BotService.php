<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Event;
use App\Exceptions\BotException;
use Illuminate\Support\Arr;
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

    public function registerFromConfig(bool $clear = false): void
    {
        if($clear) {
            Cache::flush();
        }

        foreach (config('methods') as $event => $methods) {
            $this->register(Event::tryFrom($event) ?? throw new BotException('Event not found.'), $methods);
        }
    }

    public function register(Event $event, string|array $method): void
    {
        if (is_array($method)) {
            foreach ($method as $single) {
                $this->register($event, $single);
            }
            return;
        }

        if (class_exists($method) === false) {
            logger()->error("Class {$method} does not exist.");
            return;
        }

        Cache::put($event->value, Cache::get($event->value, [])[] = $method);
    }

    public function getMethods(Event|array $event): array
    {
        if(is_array($event)) {
            return collect($event)
                ->map(static fn(Event $single) => Cache::get($single->value, []))
                ->flatten()
                ->toArray();
        }

        return Cache::get($event->value, []);
    }
}
