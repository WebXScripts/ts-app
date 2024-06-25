<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\ConnectionException;
use App\Exceptions\TeamSpeakException;
use App\Outputs\BaseOutput;
use App\Outputs\SimpleOutput;
use Illuminate\Support\Str;

readonly class SocketWrapper
{
    public function __construct(
        private mixed $socket,
    )
    {
    }

    /**
     * Login to TeamSpeak3 server query
     * @return void
     * @throws ConnectionException
     */
    public function login(): void
    {
        if ($this
            ->send('login ' . config('teamspeak.serverquery_login') . ' ' . config('teamspeak.serverquery_password'))
            ->hasError()
        ) {
            throw new ConnectionException('Failed to login.', 2);
        }
    }

    /**
     * Send and receive output from server
     * @param string $command
     * @param string|null $requestedOutput
     * @return SimpleOutput
     */
    public function send(string $command, ?string $requestedOutput = null): BaseOutput
    {
        $data = '';

        $split = str_split($command, 1024);
        $split[(count($split) - 1)] .= "\n";

        collect($split)->each(function (string $part) {
            fputs($this->socket, $part);
        });

        do {
            $data .= stream_get_contents(
                $this->socket,
                4096
            );

            if (socket_closed($this->socket)) {
                logger()->error('Connection closed.');
                exit(-1);
            }

            if (Str::contains($data, 'Welcome to the TeamSpeak 3 ServerQuery interface')) {
                $data = '';
            }

            if (Str::contains($data, 'error id=3329')) {
                logger()->error('Instance has been banned for flood.');
                exit(4);
            }

            if (app()->hasDebugModeEnabled()) {
                $trimmed = trim($data);
                if ($trimmed !== '') {
                    logger()->debug($trimmed);
                }
            }
        } while (
            Str::position($data, 'msg=') === false
            || Str::position($data, 'error id=') === false
        );

        $data = str_replace(["\r", "\n"], '', $data);

        if ($requestedOutput) {
            return (new OutputHandler(
                data: $data,
                outputClass: $requestedOutput
            ))->handle();
        }

        return SimpleOutput::createOutput($data);
    }

    /**
     * Select server by ID
     * @return void
     * @throws TeamSpeakException
     */
    public function selectServer(): void
    {
        if ($this
            ->send('use sid=' . config('teamspeak.server_id'))
            ->hasError()) {
            throw new TeamSpeakException('Failed to select server.', 2);
        }
    }

    /**
     * Register for events to listen
     * @return void
     * @throws TeamSpeakException
     */
    public function registerForEvents(): void
    {
        if (
            $this->send('servernotifyregister event=server')->hasError()
            || $this->send('servernotifyregister event=textprivate')->hasError()
        ) {
            throw new TeamSpeakException('Failed to register for events.', 3);
        }
    }

    /**
     * Set bot nickname
     * @return void
     * @throws TeamSpeakException
     */
    public function setNickname(): void
    {
        if ($this
            ->send('clientupdate client_nickname=' . str_replace(' ', '\s', config('teamspeak.bot_nickname')))
            ->hasError()
        ) {
            throw new TeamSpeakException('Failed to set nickname.', 5);
        }
    }
}
