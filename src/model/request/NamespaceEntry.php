<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class NamespaceEntry implements JsonSerializable
{
    private string $title;
    private NamespaceData $data;

    public static function new(): NamespaceEntry
    {
        return new NamespaceEntry();
    }

    public function title(string $title): NamespaceEntry
    {
        $this->title = $title;
        return $this;
    }

    public function data(NamespaceData $data): NamespaceEntry
    {
        $this->data = $data;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'data' => $this->data,
        ];
    }
}
