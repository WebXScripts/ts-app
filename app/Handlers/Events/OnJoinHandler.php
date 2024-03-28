<?php

declare(strict_types=1);

namespace App\Handlers\Events;

use App\Outputs\Events\ClientJoinOutput;
use App\Outputs\Events\EventOutput;
use App\TeamSpeakApi;
use SensitiveParameter;

readonly class OnJoinHandler extends TeamSpeakEvent
{
    public function __construct(
        #[SensitiveParameter]
        private TeamSpeakApi $api,
        private string       $data
    )
    {
        $this->process();
    }

    protected function process(): void
    {
        $this->runMethods($this->decode($this->data));
    }

    protected function runMethods(
        EventOutput $client
    ): void
    {
        collect(config('teamspeak.functions.on_join'))
            ->filter(static fn($function) => class_exists($function['class']))
            ->filter(static fn($function) => $function['enabled'])
            ->each(fn($function) => new $function['class'](
                $this->api,
                $client
            ));
    }

    protected function decode(string $data): ClientJoinOutput
    {
        return ClientJoinOutput::fromCollection(collect(explode(' ', $data))
            ->splice(1)
            ->map(static fn($value) => str_replace(["\n", "\r"], '', $value))
            ->filter(static fn($value) => !empty($value))
            ->map(static fn($value) => explode('=', $value))
            ->mapWithKeys(static fn($value) => [$value[0] => $value[1] ?? null]));
    }
}
