<?php

declare(strict_types=1);

namespace App\Inputs;

use App\Traits\IsInput;

readonly class ChannelEdit
{
    use IsInput;
    
    public function __construct(
        private int     $cid,
        private ?string $channel_name = null,
        private ?string $channel_topic = null,
        private ?string $channel_description = null,
    )
    {
    }
}
