<?php

namespace App\Exceptions;

use Exception;

class AuthorizationException extends Exception
{
    protected $code = 403;
    protected $message = "Unauthorized action";
    protected $errors = null;

    public function __construct($message = null, $errors = null) {
        if ($message) $this->message = $message;
        if ($errors) $this->errors = $errors;

        parent::__construct($this->message, $this->code);
    }

    public function getErrors(): mixed {
        return $this->errors;
    }
}
