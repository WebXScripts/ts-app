<?php

namespace App\Commands;

use App\TeamSpeak;
use App\Utils\ConsoleWrapper;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Helper\OutputWrapper;
use Throwable;

class Start extends Command
{
    protected $signature = 'bot:start';

    protected $description = 'Starts the bot.';

    public function handle(): void
    {
        $this->title(__('bot.welcome'));
        app()->instance('console', new ConsoleWrapper($this->output));
        $bot = TeamSpeak::up();
        try {
            $bot->boot()
                ->wrapper()
                ->login()
                ->selectServer()
                ->setNickname()
                ->registerForEvents();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return;
        }

        $bot->listen();
    }
}
