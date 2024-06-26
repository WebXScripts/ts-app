<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle as Output;

class ConsoleWrapper
{
    use InteractsWithIO;
    protected $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
        $this->output->setDecorated(true);
    }
}
