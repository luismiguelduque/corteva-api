<?php

namespace App\Repositories\Settings;

use App\Models\Settings\Role;

class RoleRepository
{

    /**
     * @var Role
     */
    protected $role;

    /**
     * RoleRepository constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get all records.
     *
     * @return Collection $role
     */
    public function getAll()
    {
        return $this->role->get();
    }
}