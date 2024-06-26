<?php

declare(strict_types=1);

namespace App;

use App\Api\BotApi;
use App\Api\ChannelApi;
use App\Api\ClientApi;
use App\Api\ServerApi;
use App\Utils\SocketWrapper;

final readonly class TeamSpeakApi
{
    public ClientApi $client;
    public ChannelApi $channel;
    public ServerApi $server;
    public BotApi $bot;

    public function __construct(
        private SocketWrapper $socketWrapper,
    )
    {
        $this->client = app(ClientApi::class, ['socketWrapper' => &$this->socketWrapper]);
        $this->channel = app(ChannelApi::class, ['socketWrapper' => &$this->socketWrapper]);
        $this->server = app(ServerApi::class, ['socketWrapper' => &$this->socketWrapper]);
        $this->bot = app(BotApi::class, ['socketWrapper' => &$this->socketWrapper]);

        out()->info('TeamSpeak API initialized.');
    }
}
