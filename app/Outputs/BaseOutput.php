<?php

declare(strict_types=1);

namespace App\Outputs;

interface BaseOutput
{
    public static function createOutput(array $data): self;
}
