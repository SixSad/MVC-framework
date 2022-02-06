<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class LatinaValidator extends AbstractValidator
{

    protected string $message = 'Field:input must be in Latin only';

    public function rule(): bool
    {
        return preg_match('/^[a-z0-9]+$/i',$this->value);
    }
}
