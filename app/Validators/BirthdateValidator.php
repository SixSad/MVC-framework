<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class BirthdateValidator extends AbstractValidator
{

    protected string $message = 'Field:enter the correct date';

    public function rule(): bool
    {
        return strtotime($this->value) < time();
    }
}
