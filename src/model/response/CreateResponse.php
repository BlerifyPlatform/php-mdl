<?php

namespace Blerify\Model\Response;

use JsonSerializable;

class CreateResponse
{
    private $credential;
    private $signingMessage;

    public static function fromArray(array $data): self
    {
        $response = new self();
        $response->credential = $data['credential'] ?? null;
        $response->signingMessage = $data['signingMessage'] ?? null;
        return $response;
    }

    public function getCredential(): ?object
    {
        return $this->credential;
    }
    public function getSigningMessage(): ?string
    {
        return $this->signingMessage;
    }
}
