<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Create implements JsonSerializable
{
    private string $templateId;
    private AdditionalData $additionalData;

    private OrganizationUser $organizationUser;

    private Options $options;

    public static function new(): Create
    {
        return new Create();
    }

    public function templateId($templateId): Create
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function additionalData($additionalData): Create
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function organizationUser($organizationUser): Create
    {
        $this->organizationUser = $organizationUser;
        return $this;
    }

    public function options($options): Create
    {
        $this->options = $options;
        $this->options->additionalData(true); // for mDL it is required to have additionalData true
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'templateId' => $this->templateId,
            'additionalData' => $this->additionalData,
            'organizationUser' => $this->organizationUser,
            'options' => $this->options
        ];
    }
}
