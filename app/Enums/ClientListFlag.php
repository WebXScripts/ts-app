<?php

declare(strict_types=1);

namespace App\Enums;

enum ClientListFlag: string
{
    case UID = 'uid';
    case AWAY = 'away';
    case VOICE = 'voice';
    case TIMES = 'times';
    case GROUPS = 'groups';
    case INFO = 'info';
    case ICON = 'icon';
    case COUNTRY = 'country';
    case IP = 'ip';
    case BADGES = 'badges';

    public static function all(): array
    {
        return [
            self::UID,
            self::AWAY,
            self::VOICE,
            self::TIMES,
            self::GROUPS,
            self::INFO,
            self::ICON,
            self::COUNTRY,
            self::IP,
            self::BADGES,
        ];
    }
}
