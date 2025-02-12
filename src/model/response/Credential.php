<?php

namespace Blerify\Model\Response;

use JsonSerializable;

class Credential
{
    private $id;

    public static function fromArray(array $data): self
    {
        $response = new self();
        $response->id = $data['_id'] ?? null;
        return $response;
    }

    public function getId(): string
    {
        return $this->id;
    }

}
