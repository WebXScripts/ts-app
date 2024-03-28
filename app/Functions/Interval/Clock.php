<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Inputs\ChannelEdit;
use App\TeamSpeakApi;
use Carbon\Carbon;
use Override;
use SensitiveParameter;

class Clock extends IntervalFunction
{
    #[Override]
    public static function handle(
        #[SensitiveParameter] TeamSpeakApi $teamSpeakApi
    ): void
    {
        $teamSpeakApi->channelEdit(
            new ChannelEdit(
                cid: config('functions.interval.clock.channel_id'),
                channel_name: __('channels.clock', [
                    'time' => Carbon::now()->format(config('functions.interval.clock.format'))
                ])
            )
        );
    }
}
