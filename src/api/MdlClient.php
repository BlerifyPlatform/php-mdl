<?php

namespace Blerify\Licenses;

use Blerify\Model\Response\CreateResponse;
use Blerify\Model\Response\SignResponse;

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
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials';
        $response = $this->apiClient->call($data, $correlationId, $path, 'POST');

        if ($response['error']) {
            return $response;
        }

        return CreateResponse::fromArray($response['data']);
    }

    public function signTest($data = [], $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/crypto/sign/es256';
        $response = $this->apiClient->call($data, $correlationId, $path, 'POST');

        if ($response['error']) {
            return $response;
        }

        return SignResponse::fromArray($response['data']);
    }

    public function assemble($data = [], string $credentialId, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials/' . $credentialId . '/sign';
        $response = $this->apiClient->call($data, $correlationId, $path, 'PUT');

        if ($response['error']) {
            return $response;
        }

        return $response['data'];
    }
}
