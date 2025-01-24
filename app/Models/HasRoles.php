<?php

namespace App\Models;

trait HasRoles
{
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function assignRole(string $role): void
    {
        $this->role = $role;
        $this->save();
    }
}
