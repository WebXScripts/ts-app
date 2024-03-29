<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\TeamSpeakApi;
use SensitiveParameter;

readonly abstract class IntervalFunction
{
    public abstract static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void;
}
