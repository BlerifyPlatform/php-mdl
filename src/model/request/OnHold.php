<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class OnHold implements JsonSerializable
{
    private bool $status;
    private StateChangeMetadata $metadata;

    public static function new(): OnHold
    {
        return new OnHold();
    }

    public function status($status): OnHold
    {
        $this->status = $status;
        return $this;
    }

    public function metadata($metadata): OnHold
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'metadata' => $this->metadata,
        ];
    }
}
