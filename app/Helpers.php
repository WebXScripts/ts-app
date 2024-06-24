<?php

declare(strict_types=1);

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
