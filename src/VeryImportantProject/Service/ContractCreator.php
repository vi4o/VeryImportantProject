<?php

namespace VeryImportantProject\Service;


class ContractCreator extends AbstractService implements IService
{

    public function run(\VeryImportantProject\Dto\Dto $inputDto) : \VeryImportantProject\Dto\Dto
    {
        //Do stuff to create a contract
    }

    public function validateInputDto(\VeryImportantProject\Dto\Dto $inputDto)
    {
        parent::validateInputDto($inputDto);
        //Do stuff to validate the input DTO
    }
}