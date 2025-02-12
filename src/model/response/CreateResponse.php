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
        $response->credential = Credential::fromArray($data['credential']) ?? null;
        $response->signingMessage = $data['signingMessage'] ?? null;
        return $response;
    }

    public function getCredential(): Credential
    {
        return $this->credential;
    }
    public function getSigningMessage(): ?string
    {
        return $this->signingMessage;
    }
}
