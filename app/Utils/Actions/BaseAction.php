<?php

declare(strict_types=1);

namespace App\Utils\Actions;

interface BaseAction
{
    public static function handle(...$args);
}
