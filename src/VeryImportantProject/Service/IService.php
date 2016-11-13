<?php

namespace VeryImportantProject\Service;


interface IService
{
    public function run(\VeryImportantProject\Dto\Dto $inputDto) : \VeryImportantProject\Dto\Dto;
}