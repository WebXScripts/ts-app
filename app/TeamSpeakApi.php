<?php

declare(strict_types=1);

namespace App;

use App\Api\BotApi;
use App\Api\ChannelApi;
use App\Api\ClientApi;
use App\Api\ServerApi;
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
    }
}
