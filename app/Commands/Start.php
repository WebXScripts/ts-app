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
        $this->header();

        $this->info(__('start.connecting'));
        $bot = TeamSpeak::up();

        try {
            $bot->boot();
            $bot->wrapper()->login();
            $bot->wrapper()->selectServer();
            $bot->wrapper()->setNickname();
            $bot->wrapper()->registerForEvents();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->info(__('start.connected'));
        $bot->listen();
    }

    private function header(): void
    {
        $this->info(__('start.welcome'));
        $this->info(__('start.version', ['version' => config('app.version')]));
        $this->info(__('start.author', ['author' => config('app.author')]));
        $this->newLine();
    }
}
