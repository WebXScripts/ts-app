<?php

declare(strict_types=1);

namespace App\Functions\Interval;

use App\Outputs\Methods\GetClients;
use App\Outputs\Methods\Particular\Client;
use App\TeamSpeakApi;
use Illuminate\Support\Facades\Cache;
use Override;
use SensitiveParameter;

readonly class ChatAdvertising extends IntervalFunction
{
    #[Override]
    public static function handle(
        #[SensitiveParameter]
        TeamSpeakApi $teamSpeakApi
    ): void
    {
        $messages = config('functions.interval.chat_advertising.messages');
        $currentMessage = Cache::get('chat-advertising-current-message', 0);

        /** @var GetClients $clients */
        $clients = $teamSpeakApi->getClients();
        $clients->list()
            ->filter(static fn(Client $client) => $client->client_type === 0)
            ->filter(static fn(Client $client) => $client->groups->contains(config('functions.interval.chat_advertising.group_id')))
            ->each(
                static function (Client $client) use (&$teamSpeakApi, $messages, &$currentMessage) {
                    $teamSpeakApi->sendMessage($client->client_id, $messages[$currentMessage]);
                }
            );

        $currentMessage++;
        if ($currentMessage >= count($messages)) {
            $currentMessage = 0;
        }

        Cache::put('chat-advertising-current-message', $currentMessage);
    }
}
