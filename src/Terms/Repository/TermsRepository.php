<?php

namespace App\Terms\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Terms\Entity\Terms;
use Doctrine\Common\Persistence\ManagerRegistry;

class TermsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terms::class);
    }

    public function findLatest(): ?Terms
    {
        return $this->createQueryBuilder('t')
            ->addOrderBy('t.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
