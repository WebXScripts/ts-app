<?php

declare(strict_types=1);

namespace App\Traits;

trait IsInput
{
    public function toSocket(): string
    {
        return collect(get_object_vars($this))
            ->filter(static fn($value) => $value !== null)
            ->map(static fn($value, $key) => [$key, $value])
            ->map(static fn($property) => sprintf('%s=%s', $property[0], $property[1]))
            ->map(static fn($property) => str_replace(' ', '\s', $property))
            ->join(' ');
    }
}
