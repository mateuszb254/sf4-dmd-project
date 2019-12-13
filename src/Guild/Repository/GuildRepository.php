<?php

namespace App\Guild\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Guild\Entity\Guild;
use Doctrine\Common\Persistence\ManagerRegistry;

class GuildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guild::class);
    }

    public function findLatestPaginated(int $page = 1): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->addOrderBy('c.ladderPoints', 'DESC');


        return $this->paginate($queryBuilder, $page, Guild::PER_PAGE);
    }

    public function findTopGuilds(int $numberOfGuilds = Guild::NUMBER_OF_GUILDS_SIDEBAR)
    {
        return $this->createQueryBuilder('g')
            ->setMaxResults($numberOfGuilds)
            ->addOrderBy('g.ladderPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
