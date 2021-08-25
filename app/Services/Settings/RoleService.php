<?php

namespace App\Services\Settings;

use App\Repositories\Settings\RoleRepository;

class RoleService
{
    /**
     * @var $RoleRepository
    */
    protected $RoleRepository;

    /**
     * RoleService constructor.
     *
     * @param RoleRepository $RoleRepository
     */
    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    /**
     * Get all Roles.
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->RoleRepository->getAll();      
    }
}