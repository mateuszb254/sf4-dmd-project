<?php

namespace App\User\Form\Model;

use App\User\Entity\RoleGroup;
use App\User\Model\UserInterface;

class AssignUserToRoleGroup
{
    /** @var UserInterface|null */
    protected $user;

    /** @var RoleGroup|null */
    protected $roleGroup;

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     * @return self
     */
    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return RoleGroup|null
     */
    public function getRoleGroup(): ?RoleGroup
    {
        return $this->roleGroup;
    }

    /**
     * @param RoleGroup|null $roleGroup
     * @return self
     */
    public function setRoleGroup(?RoleGroup $roleGroup): self
    {
        $this->roleGroup = $roleGroup;

        return $this;
    }
}
