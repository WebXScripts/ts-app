<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\TeamSpeakApi;

abstract class IntervalFunction
{
    public abstract static function handle(TeamSpeakApi $teamSpeakApi): void;
}
