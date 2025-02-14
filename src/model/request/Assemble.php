<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Assemble implements JsonSerializable
{
    private string $templateId;
    private string $signature;
    private string $kid;
    private string $certificate;

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

    public function jsonSerialize(): array
    {
        return [
            'templateId' => $this->templateId,
            'signature' => $this->signature,
            'kid' => $this->kid,
            'certificate' => $this->certificate,
        ];
    }
}
