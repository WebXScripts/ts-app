<?php

declare(strict_types=1);

namespace App\Api;

use App\Outputs\BaseOutput;
use App\Outputs\Methods\ServerInfo;
use App\Outputs\SimpleOutput;
use App\Utils\SocketWrapper;
use Exception;
use Illuminate\Support\Facades\Log;

final readonly class ServerApi
{
    public function __construct(
        private SocketWrapper $socketWrapper
    )
    {
    }

    public function setName(string $name): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('serveredit virtualserver_name=' . escape_text($name));
        } catch (Exception $e) {
            Log::error('Failed to set server name: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to set server name.');
    }

    /**
     * @return ServerInfo|null
     */
    public function info(): ?BaseOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('serverinfo', ServerInfo::class);
        } catch (Exception $e) {
            Log::error('Failed to get server info: ' . $e);
        }

        return null;
    }
}
