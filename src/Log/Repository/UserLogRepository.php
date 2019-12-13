<?php

namespace App\Log\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Log\Entity\UserLog;
use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserLogRepository extends ServiceEntityRepository implements UserLogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLog::class);
    }

    public function findLatestByType(UserInterface $user, int $count, ?string $fullClassName = null): array
    {
        return $this->createUserLogListQuery($user, $fullClassName)
            ->setMaxResults($count)
            ->getResult();
    }

    public function findAllByType(UserInterface $user, ?string $fullClassName = null): array
    {
        return $this->createUserLogListQuery($user, $fullClassName)->getResult();
    }

    protected function createUserLogListQuery(UserInterface $user, ?string $fullClassName = null)
    {
        $queryBuilder = $this->createQueryBuilder('user_log');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('user_log.user', $user->getId())
        );

        if (null !== $fullClassName) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->isInstanceOf(
                    'user_log', $fullClassName
                )
            );
        }

        $queryBuilder->orderBy('user_log.createdAt', 'DESC');

        return $queryBuilder->getQuery();
    }
}
