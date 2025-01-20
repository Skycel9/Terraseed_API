<?php

namespace App\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    protected $code = 400;
    protected $message = "Data validation failed";
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
