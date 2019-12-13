<?php

namespace App\User\Entity;

use App\User\Model\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"name"})
 *
 * @ORM\Entity(repositoryClass="App\User\Repository\RoleGroupRepository")
 */
class RoleGroup
{
    /**
     * @var int|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string|null $name
     *
     * @ORM\Column(name="name", type="string", length=25, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var array|null $permissions stores group of role names
     *
     * @ORM\Column(name="permissions", type="array", nullable=true)
     */
    protected $permissions;

    /**
     * @var Collection|UserInterface[] $users
     *
     * @ORM\OneToMany(targetEntity="App\User\Entity\User", mappedBy="roleGroup")
     */
    protected $users;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return RoleGroup
     */
    public function setName(?string $name): RoleGroup
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    /**
     * @param array|null $permissions
     * @return RoleGroup
     */
    public function setPermissions(?array $permissions): RoleGroup
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return UserInterface[]|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param UserInterface[]|Collection $users
     * @return RoleGroup
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
        // TODO: Implement __toString() method.
    }
}
