<?php

declare(strict_types=1);

namespace App\Api;

use App\Outputs\BaseOutput;
use App\Outputs\Methods\GetClients;
use App\Outputs\SimpleOutput;
use App\Utils\SocketWrapper;
use Exception;

final readonly class ClientApi
{
    public function __construct(
        private SocketWrapper $socketWrapper
    )
    {
    }

    public function message(int $client_id, string $message): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('sendtextmessage targetmode=1 target=' . $client_id . ' msg=' . escape_text($message));
        } catch (Exception $e) {
            logger()->error('Failed to send message to client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to send message to client.');
    }

    public function poke(int $client_id, ?string $message = null): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientpoke clid=' . $client_id . ' msg=' . escape_text($message ?? ''));
        } catch (Exception $e) {
            logger()->error('Failed to poke client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to poke client.');
    }

    public function kick(int $client_id, ?string $reason = null): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientkick clid=' . $client_id . ' reasonid=5 reasonmsg=' . escape_text($reason ?? ''));
        } catch (Exception $e) {
            logger()->error('Failed to kick client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to kick client.');
    }

    public function ban(int $client_id, int $time, ?string $reason = null): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('banclient clid=' . $client_id . ' time=' . $time . ' banreason=' . escape_text($reason ?? ''));
        } catch (Exception $e) {
            logger()->error('Failed to ban client: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to ban client.');
    }

    /**
     * @param array|null $flags
     * @return GetClients
     */
    public function all(?array $flags = null): BaseOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('clientlist ' . implode(' ', array_map(static fn($flag) => '-' . $flag->value, $flags ?? [])), GetClients::class);
        } catch (Exception $e) {
            logger()->error('Failed to get clients: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to get clients.');
    }
}
