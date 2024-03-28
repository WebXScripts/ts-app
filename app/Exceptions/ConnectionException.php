<?php

namespace App\Exceptions;

use Exception;

class ConnectionException extends Exception
{
    public function __construct(
        protected $message = 'Failed to connect to the TeamSpeak server.',
        protected $code = 0,
        protected Exception|null $previous = null
    )
    {
        parent::__construct($this->message, $this->code, $this->previous);
    }
}
