<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class MdlData implements JsonSerializable
{
    private $familyName;
    private $givenName;
    private $birthdate;
    private $issueDate;
    private $expiryDate;
    private $issuingCountry;

    private $issuingAuthority;
    private $documentNumber;
    private $portrait;

    private $drivingPrivileges;

    private $unDistinguishingSign;

    public static function new(): MdlData
    {
        return new MdlData();
    }

    public function familyName($familyName): MdlData
    {
        $this->familyName = $familyName;
        return $this;
    }

    public function givenName($givenName): MdlData
    {
        $this->givenName = $givenName;
        return $this;
    }

    public function birthDate($birthdate): MdlData
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function issueDate($issueDate): MdlData
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function expiryDate($expiryDate): MdlData
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function issuingCountry($issuingCountry): MdlData
    {
        $this->issuingCountry = $issuingCountry;
        return $this;
    }

    public function issuingAuthority($authority): MdlData
    {
        $this->issuingAuthority = $authority;
        return $this;
    }

    public function documentNumber($documentNumber): MdlData
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    public function portrait($portrait): MdlData
    {
        $this->portrait = $portrait;
        return $this;
    }

    public function drivingPrivileges($drivingPrivileges): MdlData
    {
        $this->drivingPrivileges = $drivingPrivileges;
        return $this;
    }

    public function unDistinguishingSign($unDistinguishingSign): MdlData
    {
        $this->unDistinguishingSign = $unDistinguishingSign;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'family_name' => $this->familyName,
            'given_name' => $this->givenName,
            'birth_date' => $this->birthdate,
            'issue_date' => $this->issueDate,
            'expiry_date' => $this->expiryDate,
            'issuing_country' => $this->issuingCountry,
            'issuing_authority' => $this->issuingAuthority,
            'document_number' => $this->documentNumber,
            'portrait' => $this->portrait,
            'driving_privileges' => $this->drivingPrivileges,
            'un_distinguishing_sign' => $this->unDistinguishingSign
        ];
    }

}
