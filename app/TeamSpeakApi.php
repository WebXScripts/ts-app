<?php

declare(strict_types=1);

namespace App;

use App\Inputs\ChannelEdit;
use App\Outputs\BaseOutput;
use App\Outputs\Methods\GetClients;
use App\Outputs\Methods\ServerInfo;
use App\Outputs\SimpleOutput;
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

    public function sendMessage(int $client_id, string $message): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('sendtextmessage targetmode=1 target=' . $client_id . ' msg=' . str_replace(' ', '\s', $message));
        } catch (Exception $e) {
            Log::error('Failed to send message to client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to send message to client.');
    }

    public function pokeClient(int $client_id, string $message): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientpoke clid=' . $client_id . ' msg=' . str_replace(' ', '\s', $message));
        } catch (Exception $e) {
            Log::error('Failed to poke client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to poke client.');
    }

    public function setServerName(string $name): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('serveredit virtualserver_name=' . str_replace(' ', '\s', $name));
        } catch (Exception $e) {
            Log::error('Failed to set server name: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to set server name.');
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

    public function channelEdit(ChannelEdit $channelEdit): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('channeledit ' . $channelEdit->toSocket());
        } catch (Exception $e) {
            Log::error('Failed to edit channel: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to edit channel.');
    }

    public function kickClient(int $client_id, string $reason): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientkick clid=' . $client_id . ' reasonid=5 reasonmsg=' . str_replace(' ', '\s', $reason));
        } catch (Exception $e) {
            Log::error('Failed to kick client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to kick client.');
    }

    public function banClient(int $client_id, int $time, string $reason): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('banclient clid=' . $client_id . ' time=' . $time . ' banreason=' . str_replace(' ', '\s', $reason));
        } catch (Exception $e) {
            Log::error('Failed to ban client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to ban client.');
    }

    public function getClients(?array $flags = null): BaseOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientlist ' . implode(' ', array_map(static fn($flag) => '-' . $flag->value, $flags ?? [])), new GetClients());
        } catch (Exception $e) {
            Log::error('Failed to get clients: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to get clients.');
    }
}
