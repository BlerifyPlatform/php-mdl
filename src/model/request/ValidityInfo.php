<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class ValidityInfo implements JsonSerializable
{
    private $signed;
    private $validFrom;
    private $validUntil;

    public static function new(): ValidityInfo
    {
        return new ValidityInfo();
    }

    public function signed($signed): self
    {
        $this->signed = $signed;
        return $this;
    }

    public function validFrom($validFrom): self
    {
        $this->validFrom = $validFrom;
        return $this;
    }

    public function validUntil($validUntil): self
    {
        $this->validUntil = $validUntil;
        return $this;
    }
    public function jsonSerialize(): array
    {
        return [
            'signed' => $this->signed,
            'validFrom' => $this->validFrom,
            'validUntil' => $this->validUntil
        ];
    }
}
