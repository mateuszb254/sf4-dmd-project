<?php

namespace App\User\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\User\Entity\User;
use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByLogin(string $login): ?UserInterface
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults(1)
            ->where('login', $login)
            ->getQuery()
            ->getResult();
    }

    public function findOneByLoginOrEmail(string $value): ?UserInterface
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults(1)
            ->where('login', $value)
            ->orWhere('email', $value)
            ->getQuery()
            ->getResult();
    }

    public function findLatestWithRoleGroupPaginated(int $page = 1): array
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder
            ->select('u, rg')
            ->leftJoin('u.roleGroup', 'rg');

        return $this->paginate($queryBuilder, $page, User::PER_PAGE);
    }

    public function countRegisteredToday(): int
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id)');

        $qb->where('u.createdAt > :date');
        $qb->setParameter('date', (new \DateTime)->format('Y-m-d'));

        return $qb->getQuery()
            ->getSingleScalarResult();
    }
}
