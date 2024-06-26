<?php

namespace App\Commands;

use App\TeamSpeak;
use LaravelZero\Framework\Commands\Command;
use Throwable;

class Start extends Command
{
    protected $signature = 'bot:start';

    protected $description = 'Starts the bot.';

    public function handle(): void
    {
        $this->title(__('bot.welcome'));
        $this->info(__('bot.version', ['version' => config('app.version')]));
        $this->info(__('bot.author', ['author' => config('app.author')]));
        $this->newLine();

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

        $this->info(__('bot.connected'));
        $bot->listen();
    }
}
