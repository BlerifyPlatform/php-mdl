<?php

namespace Blerify\Model\Request;

use Blerify\Crypto\Utils as CryptoUtils;
use JsonSerializable;
use React\Stream\Util;
use Utils;

class Assemble implements JsonSerializable
{
    const DER_SIGNATURE_TYPE = 'DER';
    const PLAIN_SIGNATURE_TYPE  = 'PLAIN';
    private string $templateId;
    private string $signature; // hex
    private string $kid;
    private string $certificate;

    private string $signatureType;

    public static function new(): Assemble
    {
        return new Assemble();
    }

    public function templateId($templateId): Assemble
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function signature($signature): Assemble
    {
        $this->signature = $signature;
        return $this;
    }

    public function kid($kid): Assemble
    {
        $this->kid = $kid;
        return $this;
    }

    public function certificate($certificate): Assemble
    {
        $this->certificate = $certificate;
        return $this;
    }

    public function signatureType($signatureType): Assemble
    {
        if (!self::isValid($signatureType)) {
            throw new \InvalidArgumentException("Invalid signature type: $signatureType");
        }
        $this->signatureType = $signatureType;
        return $this;
    }

    public function jsonSerialize(): array
    {
        // parse signature if needed
        if ($this->signatureType === self::DER_SIGNATURE_TYPE) {
            $this->signature = CryptoUtils::derToPlainSignature($this->signature);
        }
        return [
            'templateId' => $this->templateId,
            'signature' => $this->signature,
            'kid' => $this->kid,
            'certificate' => $this->certificate,
        ];
    }

        // optional helper to validate values
    public static function isValid(string $value): bool
    {
        return in_array($value, [
            self::DER_SIGNATURE_TYPE,
            self::PLAIN_SIGNATURE_TYPE,
        ], true);
    }    

}
