<?php

namespace App\Article\Repository;

use App\Article\Entity\Article;
use App\Core\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    private const ENTITY_NAME = Article::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::ENTITY_NAME);
    }

    public function findLatestPaginated(int $page, ?int $articleStatus, int $perPage): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->addOrderBy('a.createdAt', 'DESC');

        if (null !== $articleStatus) {
            $queryBuilder->where(
                $queryBuilder->expr()->eq('a.status', $articleStatus)
            );
        }

        return $this->paginate($queryBuilder, $page, $perPage);
    }
}
