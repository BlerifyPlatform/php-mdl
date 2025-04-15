<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class Validate implements JsonSerializable
{
    private string $mdoc;

    public static function new(): Validate
    {
        return new Validate();
    }

    public function mdoc($mdoc): Validate
    {
        $this->mdoc = $mdoc;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'mdoc' => $this->mdoc,
        ];
    }
}
