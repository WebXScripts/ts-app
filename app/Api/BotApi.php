<?php

declare(strict_types=1);

namespace App\Api;

use App\Outputs\SimpleOutput;
use App\Utils\SocketWrapper;
use Exception;

final readonly class BotApi
{
    public function __construct(
        private SocketWrapper $socketWrapper
    )
    {
    }

    public function keepAlive(): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('whoami');
        } catch (Exception $e) {
            return new SimpleOutput(100, 'Failed to keep alive - check the logs.');
        }
    }
}
