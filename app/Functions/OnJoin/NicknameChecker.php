<?php

declare(strict_types=1);

namespace App\Functions\OnJoin;

use Override;

readonly class NicknameChecker extends OnJoinFunction
{
    #[Override]
    public function handle(): void
    {
        collect(config('functions.on_join.nickname_checker.bad_nicknames'))
            ->each(function (string $badNickname) {
                if (str_contains(strtolower($this->data->client_nickname), strtolower($badNickname))) {
                    match (config('functions.on_join.nickname_checker.punishment')) {
                        'ban' => $this->banUser(),
                        default => $this->kickUser()
                    };
                }
            });
    }

    private function banUser(): void
    {
        $this->teamSpeakApi->client->kick(
            $this->data->client_id,
            config('functions.on_join.nickname_checker.ban_time'),
            __('messages.wrong_nickname')
        );
    }

    private function kickUser(): void
    {
        $this->teamSpeakApi->client->kick(
            $this->data->client_id,
            __('messages.wrong_nickname')
        );
    }
}
