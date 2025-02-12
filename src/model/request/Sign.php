<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Sign implements JsonSerializable
{
    private $jwk;
    private $signingMessage;

    public static function new(): Sign
    {
        return new Sign();
    }

    public function jwk($jwk): Sign
    {
        $this->jwk = $jwk;
        return $this;
    }

    public function signingMessage($signingMessage): Sign
    {
        $this->signingMessage = $signingMessage;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'jwk' => $this->jwk,
            'signingMessage' => $this->signingMessage
        ];
    }
}
