<?php

declare(strict_types=1);

namespace App\Handlers\Events;

use App\Outputs\Events\EventOutput;
use App\TeamSpeakApi;

readonly abstract class TeamSpeakEvent
{
    public abstract function __construct(
        #[\SensitiveParameter]
        TeamSpeakApi $api,
        string $data
    );

    protected abstract function process(): void;

    protected abstract function decode(string $data): mixed;

    protected abstract function runMethods(EventOutput $client): void;
}
