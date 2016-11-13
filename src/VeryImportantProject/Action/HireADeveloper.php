<?php

namespace VeryImportantProject\Action;


class HireADeveloper
{
    /**
     * @var \VeryImportantProject\Service\HireADeveloper
     */
    private $hireADeveloperService;
    /**
     * @var RequestMapperFactory
     */
    private $requestMapperFactory;
    /**
     * @var ResponseMapperFactory
     */
    private $responseMapperFactory;

    public function __construct(
        JsonRPCResponse $response,
        \VeryImportantProject\Service\HireADeveloper $hireADeveloperService,
        RequestMapperFactory $requestMapperFactory,
        ResponseMapperFactory $responseMapperFactory
    )
    {
        $this->response = $response;
        $this->hireADeveloperService = $hireADeveloperService;
        $this->requestMapperFactory = $requestMapperFactory;
        $this->responseMapperFactory = $responseMapperFactory;
    }

    public function __invoke(JsonRPCRequest $request) : JsonRPCResponse
    {
        // some stuff maybe
        $inputDto = $this->requestMapperFactory->
            buildMapper(get_class($this->hireADeveloperService))->
            mapRequestToInputDto($request);

        $this->hireADeveloperService->run($inputDto);

        $response = $this->responseMapperFactory->
            buildMapper(get_class($this->hireADeveloperService))->
            mapOutputDtoToResponse($request);

        return $response;
    }

}