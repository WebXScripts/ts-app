<?php

declare(strict_types=1);

namespace App\Outputs;

use App\Traits\IsOutput;

class SimpleOutput implements BaseOutput
{
    use IsOutput;

    public function __construct(
        public int    $error_id,
        public string $message,
    )
    {
    }

    public static function createOutput(array $data): self
    {
        return new self(
            error_id: (int)str_replace('error id=', '', $data[1]),
            message: str_replace('msg=', '', $data[2])
        );
    }
}
