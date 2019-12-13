<?php

namespace App\Character\Repository;

use App\Character\Entity\Character;
use App\Core\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findByName($name, $mastersExcluded = Character::MASTERS_EXCLUDED): ?Character
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('c.name', ':name'))
            ->setParameter(':name', $name)
            ->setMaxResults(1);

        $this->addExcludeMastersIfNeeded($queryBuilder, $mastersExcluded);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findLatestPaginated(int $page = 1, bool $mastersExcluded = Character::MASTERS_EXCLUDED): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->addOrderBy('c.level', 'DESC');

        $this->addExcludeMastersIfNeeded($queryBuilder, $mastersExcluded);

        return $this->paginate($queryBuilder, $page, Character::PER_PAGE);
    }

    public function findTopCharacters(int $numberOfChars = Character::NUMBER_OF_CHARS_SIDEBAR, bool $mastersExcluded = Character::MASTERS_EXCLUDED): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->setMaxResults($numberOfChars)
            ->addOrderBy('c.level', 'DESC');

        $this->addExcludeMastersIfNeeded($queryBuilder, $mastersExcluded);

        return $queryBuilder->getQuery()->getResult();
    }

    protected function addExcludeMastersIfNeeded(QueryBuilder $queryBuilder, bool $mastersExcluded = Character::MASTERS_EXCLUDED): QueryBuilder
    {
        if (true === $mastersExcluded) {
            $queryBuilder
                ->leftJoin('c.gameMaster', 'gm')
                ->andWhere($queryBuilder->expr()->isNull('gm'));
        }

        return $queryBuilder;
    }
}
