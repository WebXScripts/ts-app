<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ConnectionException;
use App\Handlers\Events\OnJoinHandler;
use App\Utils\BotManager;
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

    public static function up(): self
    {

        $manager = app(BotManager::class);
        $manager->botUID();

        if (config('app.use_dashboard')) {
            $manager->sendPingToDashboard();
        }

        return new self();
    }

    /**
     * Connect to the TeamSpeak server.
     * @return void
     * @throws ConnectionException
     */
    public function boot(): void
    {
        $this->socket = fsockopen(
            config('teamspeak.host'),
            config('teamspeak.query_port'),
            $errorCode,
            $errorString
        );

        if ($this->socket === false || !is_resource($this->socket)) {
            throw new ConnectionException($errorString, $errorCode);
        }

        if (!Str::contains(fgets($this->socket), 'TS3')) {
            throw new ConnectionException('Instance is not a TeamSpeak server.', 1);
        }

        $this->socketWrapper = new SocketWrapper($this->socket);
        $this->api = new TeamSpeakApi($this->socketWrapper);

        $this->loadedIntervalFunctions = collect(config('functions.interval'))
            ->filter(static fn($function) => $function['enabled']);

        stream_set_blocking($this->socket, false);
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
