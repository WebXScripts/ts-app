<?php

declare(strict_types=1);

namespace App\Api;

use App\Inputs\ChannelEdit;
use App\Outputs\SimpleOutput;
use App\Utils\SocketWrapper;
use Exception;
use Illuminate\Support\Facades\Log;

final readonly class ChannelApi
{
    public function __construct(
        private SocketWrapper $socketWrapper
    )
    {
    }

    public function edit(ChannelEdit $channelEdit): SimpleOutput
    {
        try {
            return $this
                ->socketWrapper
                ->send('channeledit ' . $channelEdit->toSocket());
        } catch (Exception $e) {
            Log::error('Failed to edit channel: ' . $e);
        }

        return new SimpleOutput(1, 'Failed to edit channel.');
    }
}
