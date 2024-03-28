<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

use Override;

readonly class WelcomePoke extends OnJoinFunction
{
    #[Override]
    public function handle(): void
    {
        if ($this->data->client_type !== 0) {
            return;
        }

        $this->teamSpeakApi->pokeClient(
            $this->data->client_id,
            __('messages.welcome_poke', ['nickname' => $this->data->client_nickname])
        );
    }
}
