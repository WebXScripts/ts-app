<?php

declare(strict_types=1);

namespace App\Traits;

trait IsOutput
{
    public function toArray(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    public function hasError(): bool
    {
        if (isset($this->error_id)) {
            return $this->error_id !== 0;
        }
        
        return false;
    }
}
