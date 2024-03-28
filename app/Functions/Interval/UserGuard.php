<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Enums\ClientListFlag;
use App\Outputs\Methods\GetClients;
use App\Outputs\Methods\Particular\Client;
use App\TeamSpeakApi;
use Override;
use SensitiveParameter;

class UserGuard extends IntervalFunction
{
    #[Override]
    public static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        /** @var GetClients $response */
        $response = $teamSpeakApi->getClients([
            ClientListFlag::INFO
        ]);

        $response->clients
            ->filter(static fn(Client $client) => $client->client_type === 0)
            ->each(
                static function (Client $client) use (&$teamSpeakApi) {
                    if (config('functions.interval.user_guard.check_nickname')) {
                        self::checkNickname($client, $teamSpeakApi);
                    }

                    if (config('functions.interval.user_guard.check_description')) {
                        self::checkDescription($client, $teamSpeakApi);
                    }
                }
            );
    }

    private static function checkNickname(
        Client       $client,
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        collect(config('functions.interval.user_guard.bad_words'))
            ->each(
                static function (string $badWord) use ($client, $teamSpeakApi) {
                    if (str_contains(strtolower($client->nickname), strtolower($badWord))) {
                        match (config('functions.interval.user_guard.punishment')) {
                            'ban' => $teamSpeakApi->banClient(
                                $client->client_id,
                                config('functions.interval.user_guard.ban_time'),
                                __('messages.wrong_nickname')
                            ),
                            default => $teamSpeakApi->kickClient(
                                $client->client_id,
                                __('messages.wrong_nickname')
                            )
                        };
                    }
                }
            );
    }

    private static function checkDescription(
        Client       $client,
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        if ($client->description === null) {
            return;
        }

        collect(config('functions.interval.user_guard.bad_words'))
            ->each(
                static function (string $badWord) use ($client, $teamSpeakApi) {
                    if (str_contains(strtolower($client->description), strtolower($badWord))) {
                        match (config('functions.interval.user_guard.punishment')) {
                            'ban' => $teamSpeakApi->banClient(
                                $client->client_id,
                                config('functions.interval.user_guard.ban_time'),
                                __('messages.wrong_description')
                            ),
                            default => $teamSpeakApi->kickClient(
                                $client->client_id,
                                __('messages.wrong_description')
                            )
                        };
                    }
                }
            );
    }
}
