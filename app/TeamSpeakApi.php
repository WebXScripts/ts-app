<?php

declare(strict_types=1);

namespace App;

use App\Outputs\BaseOutput;
use App\Outputs\Methods\ServerInfo;
use App\Utils\SocketWrapper;
use Exception;
use Illuminate\Support\Facades\Log;

final readonly class TeamSpeakApi
{
    public function __construct(
        private SocketWrapper $socketWrapper,
    )
    {
    }

    public function sendMessage(int $client_id, string $message): void
    {
        try {
            if (
                $this
                    ->socketWrapper
                    ->send('sendtextmessage targetmode=1 target=' . $client_id . ' msg=' . str_replace(' ', '\s', $message))
                    ->hasError()
            ) {
                Log::error('Failed to send message to client: ' . $client_id);
            }
        } catch (Exception $e) {
            Log::error('Failed to send message to client: ' . $e);
        }
    }

    public function pokeClient(int $client_id, string $message): void
    {
        try {
            if (
                $this
                    ->socketWrapper
                    ->send('clientpoke clid=' . $client_id . ' msg=' . str_replace(' ', '\s', $message))
                    ->hasError()
            ) {
                Log::error('Failed to poke client: ' . $client_id);
            }
        } catch (Exception $e) {
            Log::error('Failed to poke client: ' . $e);
        }
    }

    public function setServerName(string $name): void
    {
        try {
            if (
                $this
                    ->socketWrapper
                    ->send('serveredit virtualserver_name=' . str_replace(' ', '\s', $name))
                    ->hasError()
            ) {
                Log::error('Failed to set server name.');
            }
        } catch (Exception $e) {
            Log::error('Failed to set server name: ' . $e);
        }
    }

    public function getServerInfo(): ?BaseOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('serverinfo', new ServerInfo());
        } catch (Exception $e) {
            Log::error('Failed to get server info: ' . $e);
        }

        return null;
    }
}
