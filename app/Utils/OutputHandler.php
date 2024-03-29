<?php

declare(strict_types=1);

namespace App\Utils;

use App\Outputs\BaseOutput;
use App\Outputs\SimpleOutput;
use Illuminate\Support\Facades\Log;

readonly class OutputHandler
{
    public function __construct(
        private string $data,
        private string $outputClass
    )
    {
    }

    public function handle(): BaseOutput
    {
        if (!class_exists($this->outputClass)) {
            Log::error('Output class does not exist.');

            return new SimpleOutput(
                error_id: 10,
                message: 'Output class does not exist.'
            );
        }

        if (!method_exists($this->outputClass, 'createOutput')) {
            Log::error('Output class does not have a createOutput method.');

            return new SimpleOutput(
                error_id: 11,
                message: 'Output class does not have a createOutput method.'
            );
        }

        return call_user_func($this->outputClass . '::createOutput', $this->data);
    }
}
