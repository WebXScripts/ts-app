<?php

declare(strict_types=1);

use App\Utils\ConsoleWrapper;
use Illuminate\Console\OutputStyle as Output;

if (!function_exists('bool_null')) {
    function bool_null(... $args): ?bool
    {
        if (!array_key_exists('field', $args)) {
            throw new Exception('Field is required');
        }

        if ($args['field'] || is_bool($args['field']) === false) {
            return null;
        }

        return (bool)$args['field'];
    }
}

if (!function_exists('escape_text')) {
    function escape_text(string $text): string
    {
        $replacements = collect([
            "\t" => '\t',
            "\v" => '\v',
            "\r" => '\r',
            "\n" => '\n',
            "\f" => '\f',
            ' '  => '\s',
            '|'  => '\p',
            '/'  => '\/'
        ]);

        $replacements->each(static function ($replacement, $search) use (&$text) {
            $text = str_replace($search, $replacement, $text);
        });

        return $text;
    }
}

if (!function_exists('socket_closed')) {
    function socket_closed(mixed $socket): bool
    {
        return !is_resource($socket) || feof($socket);
    }
}

if (!function_exists('out')) {
    function out(): ConsoleWrapper
    {
        return app('console');
    }
}
