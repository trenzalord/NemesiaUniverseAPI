<?php

namespace NemesiaUniverse;

class Token
{
    public $decoded;

    public function hydrate($decoded)
    {
        $this->decoded = $decoded;
    }

    public function hasRole($role)
    {
        return $this->decoded->role == $role;
    }
}
