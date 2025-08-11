<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class NamespaceData implements JsonSerializable
{
    private string $bloodType;
    private bool $organDonor;
    private string $citizenIdNumber;
    private string $citizenIdType;

    public static function new(): NamespaceData
    {
        return new NamespaceData();
    }

    public function bloodType(string $bloodType): NamespaceData
    {
        $this->bloodType = $bloodType;
        return $this;
    }

    public function organDonor(bool $organDonor): NamespaceData
    {
        $this->organDonor = $organDonor;
        return $this;
    }

    public function citizenIdNumber(string $citizenIdNumber): NamespaceData
    {
        $this->citizenIdNumber = $citizenIdNumber;
        return $this;
    }

    public function citizenIdType(string $citizenIdType): NamespaceData
    {
        $this->citizenIdType = $citizenIdType;
        return $this;
    }
    public function jsonSerialize(): array
    {
        return [
            'bloodType' => $this->bloodType,
            'organDonor' => $this->organDonor,
            'citizenIdNumber' => $this->citizenIdNumber,
            'citizenIdType' => $this->citizenIdType,
        ];
    }
}
