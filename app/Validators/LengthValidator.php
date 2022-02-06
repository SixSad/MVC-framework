<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class LengthValidator extends AbstractValidator
{

    protected string $message = 'Field :field must be at least 8 characters long';

    public function rule(): bool
    {
        return strlen($this->value) >= 8 ;
    }
}
