<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Inputs\ChannelEdit;
use App\Outputs\Methods\ServerInfo;
use App\TeamSpeakApi;
use Override;
use SensitiveParameter;

readonly class ClientsOnline extends IntervalFunction
{
    #[Override]
    public static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        $serverInfo = $teamSpeakApi->server->info();
        if (!$serverInfo->hasError()) {
            $teamSpeakApi->channel->edit(
                new ChannelEdit(
                    cid: config('functions.interval.clients_online.channel_id'),
                    channel_name: __('channels.clients_online', [
                        'online' => $serverInfo->clients_online - 1,
                        'max' => $serverInfo->max_clients
                    ])
                )
            );
        }
    }
}
