<?php

use App\TeamSpeak;

beforeEach(function () {
    $this->bot = TeamSpeak::up();
    $this->bot->boot();
    $this->bot->wrapper()->login();
    $this->bot->wrapper()->selectServer();
    $this->bot->wrapper()->setNickname();
    $this->bot->wrapper()->registerForEvents();
});

test('query stress', function () {
    $hasError = false;
    for ($i = 0; $i < 100; $i++) {
        try {
            if($this->bot->api()->client->message(1, 'Hello, World!')
                ->hasError()) {
                throw new Exception('Failed to send message.');
            }

            if (
                $this->bot->api()->channel->edit(
                    new \App\Inputs\ChannelEdit(
                        cid: 2,
                        channel_name: random_int(1, 1000) . ' Channel',
                    )
                )->hasError()
                || $this->bot->api()->channel->edit(
                    new \App\Inputs\ChannelEdit(
                        cid: 3,
                        channel_name: random_int(1, 1000) . ' Channel',
                    )
                )->hasError()
                || $this->bot->api()->channel->edit(
                    new \App\Inputs\ChannelEdit(
                        cid: 4,
                        channel_name: random_int(1, 1000) . ' Channel',
                    )
                )->hasError()
            ) {
                throw new Exception('Failed to edit channel.');
            }
        } catch (Throwable $e) {
            $hasError = true;
            break;
        }
    }
    $this->assertTrue(!$hasError);
})->skip('This test is too slow to run on every test run.');
