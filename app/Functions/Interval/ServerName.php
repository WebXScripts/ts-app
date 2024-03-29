<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Outputs\Methods\ServerInfo;
use App\TeamSpeakApi;
use Override;
use SensitiveParameter;

readonly class ServerName extends IntervalFunction
{
    #[Override]
    public static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        /** @var ?ServerInfo $serverInfo */
        $serverInfo = $teamSpeakApi->getServerInfo();
        if (
            $serverInfo === null
            || $serverInfo->hasError()
            || str_replace('\s', ' ', $serverInfo->virtual_server_name)
            === $serverName = __('server.name', [
                'max' => $serverInfo->max_clients,
                'online' => $serverInfo->clients_online - 1,
            ])
        ) {
            return;
        }

        $teamSpeakApi->setServerName(str_replace(' ', '\s', $serverName));
    }
}
