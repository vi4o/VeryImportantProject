<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 13.11.2016 г.
 * Time: 18:09 ч.
 */

namespace VeryImportantProject\Validation;


interface IValidator
{
    public function isValid($input) : bool;
}