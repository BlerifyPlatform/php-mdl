<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class MdlData implements JsonSerializable
{
    private ?string $familyName=null;
    private ?string $givenName=null;
    private ?string $birthdate=null;
    private ?string $issueDate=null;
    private ?string $expiryDate=null;
    private ?string $issuingCountry=null;

    private ?string $issuingAuthority=null;
    private ?string $documentNumber=null;
    private ?string $portrait=null;

    private $drivingPrivileges=null;

    private ?string $unDistinguishingSign=null;

    private ?string $administrativeNumber=null;

    private ?int $sex=null;

    private ?int $height=null;
    private ?int $weight=null;

    private ?string $eyeColour=null;

    private ?string $birthPlace=null;
    private ?string $residentAddress=null;
    private ?string $issuingJurisdiction=null;
    private ?string $nationality=null;
    private ?string $residentCity=null;
    private ?string $residentState=null;
    private ?string $residentPostalCode=null;
    private ?string $residentCountry=null;

    public static function new(): MdlData
    {
        return new MdlData();
    }

    public function familyName(string $familyName): MdlData
    {
        $this->familyName = $familyName;
        return $this;
    }

    public function givenName(string $givenName): MdlData
    {
        $this->givenName = $givenName;
        return $this;
    }

    public function birthDate(string $birthdate): MdlData
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function issueDate(string $issueDate): MdlData
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function expiryDate(string $expiryDate): MdlData
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function issuingCountry(string $issuingCountry): MdlData
    {
        $this->issuingCountry = $issuingCountry;
        return $this;
    }

    public function issuingAuthority(string $authority): MdlData
    {
        $this->issuingAuthority = $authority;
        return $this;
    }

    public function documentNumber(string $documentNumber): MdlData
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    public function portrait(string $portrait): MdlData
    {
        $this->portrait = $portrait;
        return $this;
    }

    public function drivingPrivileges($drivingPrivileges): MdlData
    {
        $this->drivingPrivileges = $drivingPrivileges;
        return $this;
    }

    public function unDistinguishingSign(string $unDistinguishingSign): MdlData
    {
        $this->unDistinguishingSign = $unDistinguishingSign;
        return $this;
    }

    public function administrativeNumber(string $administrativeNumber): MdlData
    {
        $this->administrativeNumber = $administrativeNumber;
        return $this;
    }

    public function sex(int $sex): MdlData
    {
        $this->sex = $sex;
        return $this;
    }

    public function height(int $height): MdlData
    {
        $this->height = $height;
        return $this;
    }

    public function weight(int $weight): MdlData
    {
        $this->weight = $weight;
        return $this;
    }

    public function eyeColour(string $eyeColour): MdlData
    {
        $this->eyeColour = $eyeColour;
        return $this;
    }

    public function birthPlace(string $birthPlace): MdlData
    {
        $this->birthPlace = $birthPlace;
        return $this;
    }

    public function residentAddress(string $residentAddress): MdlData
    {
        $this->residentAddress = $residentAddress;
        return $this;
    }
    
    public function issuingJurisdiction(string $issuingJurisdiction): MdlData
    {
        $this->issuingJurisdiction = $issuingJurisdiction;
        return $this;
    }

    public function nationality(string $nationality): MdlData
    {
        $this->nationality = $nationality;
        return $this;
    }
    public function residentCity(string $residentCity): MdlData
    {
        $this->residentCity = $residentCity;
        return $this;
    }
    public function residentState(string $residentState): MdlData
    {
        $this->residentState = $residentState;
        return $this;
    }

    public function residentPostalCode(string $residentPostalCode): MdlData
    {
        $this->residentPostalCode = $residentPostalCode;
        return $this;
    }
    public function residentCountry(string $residentCountry): MdlData
    {
        $this->residentCountry = $residentCountry;
        return $this;
    }

    public function jsonSerialize(): array
    {
        if ($this->familyName !== null) {
            $data['family_name'] = $this->familyName;
        }

        if ($this->givenName !== null) {
            $data['given_name'] = $this->givenName;
        }
        if ($this->birthdate !== null) {
            $data['birth_date'] = $this->birthdate;
        }
        if ($this->issueDate !== null) {
            $data['issue_date'] = $this->issueDate;
        }
        if ($this->expiryDate !== null) {
            $data['expiry_date'] = $this->expiryDate;
        }
        if ($this->issuingCountry !== null) {
            $data['issuing_country'] = $this->issuingCountry;
        }
        if ($this->issuingAuthority !== null) {
            $data['issuing_authority'] = $this->issuingAuthority;
        }
        if ($this->documentNumber !== null) {
            $data['document_number'] = $this->documentNumber;
        }
        if ($this->portrait !== null) {
            $data['portrait'] = $this->portrait;
        }
        if ($this->drivingPrivileges !== null) {
            $data['driving_privileges'] = $this->drivingPrivileges;
        }
        if ($this->unDistinguishingSign !== null) {
            $data['un_distinguishing_sign'] = $this->unDistinguishingSign;
        }
        if ($this->administrativeNumber !== null) {
            $data['administrative_number'] = $this->administrativeNumber;
        }
        if ($this->sex !== null) {
            $data['sex'] = $this->sex;
        }
        if ($this->height !== null) {
            $data['height'] = $this->height;
        }
        if ($this->weight !== null) {
            $data['weight'] = $this->weight;
        }
        if ($this->eyeColour !== null) {
            $data['eye_colour'] = $this->eyeColour;
        }
        if ($this->birthPlace !== null) {
            $data['birth_place'] = $this->birthPlace;
        }
        if ($this->residentAddress !== null) {
            $data['resident_address'] = $this->residentAddress;
        }
        if ($this->issuingJurisdiction !== null) {
            $data['issuing_jurisdiction'] = $this->issuingJurisdiction;
        }
        if ($this->nationality !== null) {
            $data['nationality'] = $this->nationality;
        }

        if ($this->residentCity !== null) {
            $data['resident_city'] = $this->residentCity;
        }
        if ($this->residentState !== null) {
            $data['resident_state'] = $this->residentState;
        }
        if ($this->residentPostalCode !== null) {
            $data['resident_postal_code'] = $this->residentPostalCode;
        }
        if ($this->residentCountry !== null) {
            $data['resident_country'] = $this->residentCountry;
        }

        return $data;
    }

}
