<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

use Override;

readonly class WelcomePoke extends OnJoinFunction
{
    #[Override]
    public function handle(): void
    {
        $this->teamSpeakApi->client->poke(
            $this->data->client_id,
            __('messages.welcome_poke', ['nickname' => $this->data->client_nickname])
        );
    }
}
