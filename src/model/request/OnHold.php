<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class OnHold implements JsonSerializable
{
    private bool $status;
    private string $reasonCode;

    public static function new(): OnHold
    {
        return new OnHold();
    }

    public function status($status): OnHold
    {
        $this->status = $status;
        return $this;
    }

    public function reasonCode($reasonCode): OnHold
    {
        $this->reasonCode = $reasonCode;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'reasonCode' => $this->reasonCode,
        ];
    }
}
