<?php

namespace App\Exceptions;

use Exception;

class TeamSpeakException extends Exception
{
    public function __construct(
        protected $message = '',
        protected $code = 0,
        protected Exception|null $previous = null
    )
    {
        parent::__construct($this->message, $this->code, $this->previous);
    }
}
