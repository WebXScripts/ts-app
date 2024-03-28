<?php

declare(strict_types=1);

namespace App\Outputs;

use App\Traits\IsOutput;

abstract class BaseOutput
{
    use IsOutput;

    public abstract static function createOutput(string $data): self;
}
