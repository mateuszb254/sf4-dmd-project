<?php

namespace App\Support\Repository;

use App\Support\Entity\Ticket;
use App\Support\Entity\TicketCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

class TicketCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketCategory::class);
    }

    public function findOneByName(string $name): ?TicketCategory
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->where($qb->expr()->eq('c.name', ':name'))
            ->setMaxResults(1)
            ->setParameter(':name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllWithAmountOfUnansweredTickets()
    {
        $qb = $this->createQueryBuilder('tc');
        $qb->select('tc as category, count(tickets) as amount')
            ->leftJoin('tc.tickets', 'tickets', Expr\Join::WITH, 'tickets.status = :status')
            ->groupBy('tc')
            ->setParameter(':status', Ticket::STATUS_PENDING);

        return $qb->getQuery()->getResult();
    }
}
