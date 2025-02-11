<?php

namespace Blerify\Licenses;

use Blerify\Authentication\JwtHandler;
use Exception;

class ApiClient
{
    private $endpointBase;
    private $jwtHandler;

    public function __construct($endpointBase, $jwtHandler)
    {
        $this->endpointBase = $endpointBase;
        $this->jwtHandler = $jwtHandler;
    }

    public function request($method, $path, $data = [])
    {
        $url = $this->endpointBase . $path;

        // Get access token
        $accessToken = $this->jwtHandler->getAccessToken();

        // Prepare cURL request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}