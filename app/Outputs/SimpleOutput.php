<?php

declare(strict_types=1);

namespace App\Outputs;

use Override;

class SimpleOutput extends BaseOutput
{
    public function __construct(
        public int    $error_id,
        public string $message,
    )
    {
    }

    #[Override]
    public static function createOutput(string $data): self
    {
        $data = explode(' ', $data);
        
        return new self(
            error_id: (int)str_replace('error id=', '', $data[1]),
            message: str_replace('msg=', '', $data[2])
        );
    }
}
