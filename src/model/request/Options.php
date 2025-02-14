<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Options implements JsonSerializable
{
    private bool $additionalData;
    private bool $onboard;

    public static function new(): Options
    {
        return new Options();
    }

    public function additionalData($additionalData): Options
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function onboard($onboard): Options
    {
        $this->onboard = $onboard;
        return $this;
    }
    public function jsonSerialize(): array
    {
        return [
            'additionalData' => $this->additionalData,
            'onboard' => $this->onboard
        ];
    }
}
