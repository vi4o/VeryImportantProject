<?php

namespace VeryImportantProject\Service;


class HireADeveloper extends AbstractService implements IService
{
    /**
     * @var DeveloperFinder
     */
    protected $developerFinder;
    /**
     * @var \VeryImportantProject\Dto\HireADeveloper\Output
     */
    protected $outputDtoPrototype;
    /**
     * @var \VeryImportantProject\Validation\Str
     */
    protected $numberValidator;
    /**
     * @var \VeryImportantProject\Domain\Recruitment\InterviewRobot
     */
    private $interviewRobot;
    /**
     * @var \VeryImportantProject\Service\ContractCreator
     */
    private $contractCreator;
    /**
     * @var \VeryImportantProject\Dto\ContractCreator\Input
     */
    private $contractCreatorInputDtoPrototype;


    public function __construct(
        \VeryImportantProject\Dto\HireADeveloper\Output $outputDtoPrototype,
        \VeryImportantProject\Domain\Recruitment\DeveloperFinder $developerFinder,
        \VeryImportantProject\Domain\Recruitment\InterviewRobot $interviewRobot,
        \VeryImportantProject\Service\ContractCreator $contractCreator,
        \VeryImportantProject\Dto\ContractCreator\Input $contractCreatorInputDtoPrototype,
        \VeryImportantProject\Validation\Number $numberValidator
    )
    {
        $this->outputDtoPrototype = $outputDtoPrototype;
        $this->developerFinder = $developerFinder;
        $this->interviewRobot = $interviewRobot;
        $this->contractCreator = $contractCreator;
        $this->contractCreatorInputDtoPrototype = $contractCreatorInputDtoPrototype;
        $this->numberValidator = $numberValidator;
    }

    public function run(\VeryImportantProject\Dto\Dto $inputDto) : \VeryImportantProject\Dto\Dto
    {
        $outputDto = clone $this->outputDtoPrototype;
        try {
            $this->validateInputDto($inputDto);
            /* @var \VeryImportantProject\Dto\HireADeveloper\Input $inputDto */
            $developers = $this->developerFinder->findBySkills($this->inputDto->skills);

            $this->interviewRobot->setSkillsToAskFor($inputDto->skills);
            $this->interviewRobot->setGeneralQuestionsToAskFor($this->generalQuestionGenerator->generateQuestions($inputDto->generalQuestionsNumber));

            $interviewResult = null;
            $interviewResult = $this->interviewRobot->interview($developers);

            if ($interviewResult) {
                $contractCreatorInputDto = clone $this->contractCreatorInputDtoPrototype;
                $contractCreatorInputDto->employeeName = $interviewResult->developerToHire->getFullName();
                $contractCreatorInputDto->salary = $interviewResult->negotiatedSalary;

                $contractCreatorOutputDto = $this->contractCreator->run($contractCreatorInputDto);
                $this->outputDtoPrototype->success = $contractCreatorOutputDto->success;
                $this->outputDtoPrototype->exception = $contractCreatorOutputDto->exception;
            }
        } catch (\Exception $exception) {
            $outputDto->success = false;
            $outputDto->exception = $exception;
        }
        return $outputDto;
    }

    public function validateInputDto(\VeryImportantProject\Dto\Dto $inputDto)
    {
        parent::validateInputDto($inputDto);
        /* @var \VeryImportantProject\Dto\HireADeveloper\Input $inputDto */
        if (!count($inputDto->skills)) {
            throw new \ValidationException("Cannot hire a developer without skills!");
        }
        if ($inputDto->generalQuestionsNumber <= 0 && !$this->numberValidator->isValid($inputDto->generalQuestionsNumber)) {
            throw new \ValidationException("General skills must be positive number!");
        }
    }
}