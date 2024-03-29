<?php

declare(strict_types=1);

namespace App\Utils\Actions;

use Exception;

class BoolNull implements BaseAction
{
    /**
     * @param ...$args
     * @return bool|null
     * @throws Exception
     */
    public static function handle(...$args): ?bool
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
