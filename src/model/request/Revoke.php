<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Revoke implements JsonSerializable
{
    private StateChangeMetadata $metadata;

    public static function new(): Revoke
    {
        return new Revoke();
    }

    public function metadata($metadata): Revoke
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'metadata' => $this->metadata,
        ];
    }
}
