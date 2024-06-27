<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\BotException;
use App\Exceptions\ConnectionException;
use App\Handlers\Events\OnJoinHandler;
use App\Utils\SocketWrapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class TeamSpeak
{
    protected mixed $socket = null;

    private SocketWrapper $socketWrapper;

    private TeamSpeakApi $api;

    private Collection $loadedIntervalFunctions;

    private array $intervalFunctions = [];

    private int $keepAlive = 0;

    /**
     * @return self
     * @throws Exceptions\BotException
     */
    public static function up(): self
    {
        bot()->generateUniqueId();
        rescue(fn() => bot()->registerFromConfig(clear: true), function(BotException $exception) {
            logger()->error($exception->getMessage());
        });

        return new self();
    }

    /**
     * Connect to the TeamSpeak server.
     * @return TeamSpeak
     * @throws ConnectionException
     */
    public function boot(): self
    {
        $this->socket = stream_socket_client(
            address: "tcp://" . config('teamspeak.host') . ":" . config('teamspeak.query_port'),
            timeout: 30,
        );

        if (socket_closed($this->socket)) {
            throw new ConnectionException('Failed to connect to the TeamSpeak server.', -1);
        }

        if (!Str::contains(fgets($this->socket), ['TS3', 'TeamSpeak 3', 'ServerQuery'])) {
            throw new ConnectionException('Instance is not a TeamSpeak server.', 1);
        }

        $this->socketWrapper = new SocketWrapper($this->socket);
        $this->api = new TeamSpeakApi($this->socketWrapper);

        $this->loadedIntervalFunctions = collect(config('functions.interval'))
            ->filter(static fn($function) => $function['enabled']);

        stream_set_blocking($this->socket, false);

        return $this;
    }

    public function listen(): void
    {
        while (true) {
            $data = stream_get_contents($this->socket);

            if (Str::contains($data, 'notifycliententerview')) {
                new OnJoinHandler($this->api, $data);
            }

            $this->loadedIntervalFunctions
                ->each(function ($function) {
                    if (!isset($this->intervalFunctions[$function['class']])) {
                        $this->intervalFunctions[$function['class']] = time();
                    }

                    if (time() - $this->intervalFunctions[$function['class']] >= $function['interval']) {
                        $this->intervalFunctions[$function['class']] = time();
                        $function['class']::handle($this->api);
                    }
                });

            if (time() - $this->keepAlive >= 5) {
                $this->keepAlive = time();
                if($this->api->bot->keepAlive()->hasError()) {
                    logger()->error('Failed to send keep alive.');
                }
            }

            usleep(5000);
        }
    }

    public function api(): TeamSpeakApi
    {
        return $this->api;
    }

    public function wrapper(): SocketWrapper
    {
        return $this->socketWrapper;
    }
}
