<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Inputs\ChannelEdit;
use App\TeamSpeakApi;
use Override;
use SensitiveParameter;

class AppInformation extends IntervalFunction
{
    #[Override] public static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        $teamSpeakApi->channelEdit(
            new ChannelEdit(
                cid: config('functions.interval.app_information.channel_id'),
                channel_description: __('channels.app_information_description', [
                    'memory' => round(memory_get_usage() / 1024 / 1024, 2) . 'MB',
                    'uptime' => round(microtime(true) - LARAVEL_START, 2) . 's'
                ])
            )
        );
    }
}
