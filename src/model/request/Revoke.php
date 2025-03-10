<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Revoke implements JsonSerializable
{
    private string $reasonCode;

    public static function new(): Revoke
    {
        return new Revoke();
    }

    public function reasonCode($reasonCode): Revoke
    {
        $this->reasonCode = $reasonCode;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'reasonCode' => $this->reasonCode,
        ];
    }
}
