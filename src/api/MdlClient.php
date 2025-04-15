<?php

namespace Blerify\Licenses;

use Blerify\Model\Request\Revoke;
use Blerify\Model\Request\OnHold;
use Blerify\Model\Request\Assemble;
use Blerify\Model\Request\Create;
use Blerify\Model\Request\Sign;
use Blerify\Model\Request\Validate;
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

    public function create(Create $data, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials';
        $response = $this->apiClient->call($data, $correlationId, $path, 'POST');

        if ($response['error']) {
            return $response;
        }

        return CreateResponse::fromArray($response['data']);
    }

    public function signTest(Sign $data, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/crypto/sign/es256';
        $response = $this->apiClient->call($data, $correlationId, $path, 'POST');

        if ($response['error']) {
            return $response;
        }

        return SignResponse::fromArray($response['data']);
    }

    public function assemble(Assemble $data, string $credentialId, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials/' . $credentialId . '/sign';
        $response = $this->apiClient->call($data, $correlationId, $path, 'PUT');

        if ($response['error']) {
            return $response;
        }

        return $response['data'];
    }

    public function hold(OnHold $data, string $credentialId, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials/' . $credentialId . '/hold';
        $response = $this->apiClient->call($data, $correlationId, $path, 'PUT');

        if ($response['error']) {
            return $response;
        }

        return $response['correlation-id'];
    }

    public function revoke(Revoke $data, string $credentialId, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials/' . $credentialId . '/revoke';
        $response = $this->apiClient->call($data, $correlationId, $path, 'DELETE');

        if ($response['error']) {
            return $response;
        }

        return $response['correlation-id'];
    }

    public function validate(Validate $data, string $credentialId, $correlationId = null)
    {
        $path = '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials/' . $credentialId . '/signature/validate';
        $response = $this->apiClient->call($data, $correlationId, $path, 'POST');

        if ($response['error']) {
            return $response;
        }

        return $response['data'];
    }

}
