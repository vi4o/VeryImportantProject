<?php

namespace VeryImportantProject\Service;


abstract class AbstractService implements IService
{
    abstract public function run(\VeryImportantProject\Dto\Dto $inputDto) : \VeryImportantProject\Dto\Dto;

    public function validateInputDto(\VeryImportantProject\Dto\Dto $inputDto)
    {
        if (get_class($inputDto) !== "\\VeryImportantProject\\Dto\\" . basename(get_class($this)) . "Input") {
            throw new \ValidationException(
                "The input Dto for \"" . basename(get_class($this)) .
                "\" service must be of type " . "\"\\VeryImportantProject\\Dto\\" . basename(get_class($this)) . "Input\""
            );
        }
    }
}