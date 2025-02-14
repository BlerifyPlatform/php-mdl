<?php

namespace Blerify\Model\Request;

use JsonSerializable;

class OrganizationUser implements JsonSerializable
{
    private string $id;
    private string $did;

    public static function new(): OrganizationUser
    {
        return new OrganizationUser();
    }

    public function id($id): OrganizationUser
    {
        $this->id = $id;
        return $this;
    }

    public function did($did): OrganizationUser
    {
        $this->did = $did;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'did' => $this->did
        ];
    }
}
