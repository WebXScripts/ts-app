<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

use Override;

readonly class WelcomeMessage extends OnJoinFunction
{
    #[Override]
    public function handle(): void
    {
        $this->teamSpeakApi->sendMessage(
            $this->data->client_id,
            __('messages.welcome_pm', ['nickname' => $this->data->client_nickname])
        );
    }
}
