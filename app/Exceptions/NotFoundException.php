<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
    protected $message = "Not Found";
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
