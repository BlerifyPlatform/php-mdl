<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class AdditionalData implements JsonSerializable
{
    private MdlData $mdlData;

    private ValidityInfo $validityInfo;
    private $devicePublicKey;

    private $certificate;
    private $kid;

    public static function new(): AdditionalData
    {
        return new AdditionalData();
    }

    public function validityInfo($validityInfo): AdditionalData
    {
        $this->validityInfo = $validityInfo;
        return $this;
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

    public function certificate($certificate): AdditionalData {
        $this->certificate = $certificate;
        return $this;
    }
    public function kid($kid): AdditionalData {
        $this->kid = $kid;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'mdlData' => $this->mdlData,
            'validityInfo' => $this->validityInfo,
            'devicePublicKey' => $this->devicePublicKey,
            'certificate' => $this->certificate,
            'kid' => $this->kid
        ];
    }
}
