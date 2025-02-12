<?php

namespace Blerify\Model\Response;

use JsonSerializable;

class SignResponse
{
    private $signature;

    public static function fromArray(array $data): self
    {
        $response = new self();
        $response->signature = $data['signature'] ?? null;
        return $response;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
