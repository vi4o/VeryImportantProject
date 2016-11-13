<?php

namespace VeryImportantProject\Validation;


class Number implements IValidator
{
    public function isValid($input) : bool
    {
        return is_numeric($input);
    }
}