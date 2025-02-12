<?php

namespace Blerify\Licenses;

use Blerify\Exception\AuthenticationException;
use Blerify\Exception\HttpRequestException;
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
        try {
            $response = $this->apiClient->request(
                'POST',
                '/api/v1/organizations/' . $this->jwtHandler->getOrganizationId() . '/projects/' . $this->projectId . '/credentials',
                $data,
                $correlationId
            );
            $response = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $msg = 'JSON decode error: ' . json_last_error_msg();
                return ["error" => true, "message" => $msg, "code" => 30000];
            }
            return CreateResponse::fromArray($response);
        } catch (HttpRequestException | AuthenticationException $e) {
            return ["error" => true, "message" => $e->getMessage(), "details" => $e->getDetails(), "code" => $e->getCode()];
        } catch (Exception $e) {
            return ["error" => true, "message" => $e->getMessage(), "details" => [], "code" => $e->getCode()];
        }
    }
}
