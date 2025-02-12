<?php

namespace Blerify\Licenses;

use Blerify\Model\Response\CreateResponse;
use Exception;

class MdlClient
{
    private $apiClient;
    private $jwtHandler;

    private $projectId;
    public function __construct($baseEndpoint, $jwtHandler, $projectId)
    {
        $this->apiClient = new ApiClient($baseEndpoint, $jwtHandler);
        $this->jwtHandler = $jwtHandler;
        $this->projectId = $projectId;
    }

    public function create($data = [], $correlationId = null)
    {
        $response = $this->apiClient->request(
            'POST',
            '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials',
            $data,
            $correlationId
        );
        $response = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $msg = 'JSON decode error: ' . json_last_error_msg();
            throw new Exception($msg);
        }
        return CreateResponse::fromArray($response);
    }
}
