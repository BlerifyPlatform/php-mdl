<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Options implements JsonSerializable
{
    private bool $additionalData;
    private bool $onboard;
    private bool $update;

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
    public function update($update): Options
    {
        $this->update = $update;
        return $this;
    }
    public function jsonSerialize(): array
    {
        // validate only onboard or update can be true
        //safely check for null
        $this->onboard ??=false;
        $this->update ??= false;
        if ($this->onboard === $this->update) {
            throw new \InvalidArgumentException('Only one of onboard or update can be true');
        }
        return [
            'additionalData' => $this->additionalData,
            'onboard' => $this->onboard,
            'update' => $this->update
        ];
    }
}
