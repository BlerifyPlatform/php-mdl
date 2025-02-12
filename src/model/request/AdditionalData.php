<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class AdditionalData implements JsonSerializable
{
    private $mdlData;
    private $devicePublicKey;

    public static function new(): AdditionalData
    {
        return new AdditionalData();
    }

    public function mdlData($mdlData): AdditionalData
    {
        $this->mdlData = $mdlData;
        return $this;
    }


    public function devicePublicKey($devicePublicKey): AdditionalData
    {
        $this->devicePublicKey = $devicePublicKey;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'mdlData' => $this->mdlData,
            'devicePublicKey' => $this->devicePublicKey
        ];
    }
}
