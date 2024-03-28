<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

use App\Outputs\Events\ClientJoinOutput;
use App\TeamSpeakApi;
use SensitiveParameter;

readonly abstract class OnJoinFunction
{
    public function __construct(
        #[SensitiveParameter]
        protected TeamSpeakApi     $teamSpeakApi,
        protected ClientJoinOutput $data,
    )
    {
        $this->handle();
    }

    public abstract function handle(): void;
}
