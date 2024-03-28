<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

readonly class WelcomeMessage extends OnJoinFunction
{
    public function handle(): void
    {
        if ($this->data->client_type !== 0) {
            return;
        }
        
        $this->teamSpeakApi->sendMessage(
            $this->data->client_id,
            __('messages.welcome_pm', ['nickname' => $this->data->client_nickname])
        );
    }
}
