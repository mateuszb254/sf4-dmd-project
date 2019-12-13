<?php

namespace App\User\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\User\Entity\RoleGroup;
use Doctrine\Common\Persistence\ManagerRegistry;

class RoleGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleGroup::class);
    }

    public function findAllWithAssignedUsers()
    {
        $qb = $this->createQueryBuilder('rg');
        $qb
            ->select('rg, u')
            ->leftJoin('rg.users', 'u');

        return $qb->getQuery()->getResult();
    }
}
