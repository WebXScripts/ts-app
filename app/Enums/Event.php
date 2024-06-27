<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumAsArray;

enum Event: string
{
    use EnumAsArray;

    case ON_CLIENT_JOIN = 'on_client_join';
}
