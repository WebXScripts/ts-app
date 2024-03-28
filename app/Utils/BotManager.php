<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\BotException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BotManager
{
    public function __construct(
        private ?string $uuid = null
    )
    {
    }

    public function botUID(): void
    {
        if (File::exists(storage_path('bot_uid'))) {
            $this->uuid = File::get(storage_path('bot_uid'));
            return;
        }

        $this->uuid = Str::uuid()->toString();
        File::put(storage_path('bot_uid'), $this->uuid);
    }

    public function sendPingToDashboard(): void
    {
        if ($this->uuid) {
            // Send statistics
            return;
        }

        throw new BotException('Bot UUID is not set.');
    }
}
