<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class StateChangeMetadata implements JsonSerializable
{
    private string $code;
    private string $description;
    private string $category;

    public static function new(): StateChangeMetadata
    {
        return new StateChangeMetadata();
    }

    public function code($code): StateChangeMetadata
    {
        $this->code = $code;
        return $this;
    }

        public function description($description): StateChangeMetadata
    {
        $this->description = $description;
        return $this;
    }


        public function category($category): StateChangeMetadata
    {
        $this->category = $category;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'description' => $this->description,
            'category' => $this->category,
        ];
    }
}
