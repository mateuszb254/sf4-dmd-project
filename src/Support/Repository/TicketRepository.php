<?php

namespace App\Support\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Support\Entity\Ticket;
use App\Support\Entity\TicketCategory;
use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function findAllTicketsWithLastReplyByCategory(TicketCategory $ticketCategory = null)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->orderBy('t.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findAllPaginatedByUser(UserInterface $user, int $page = 1)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where($qb->expr()->eq('t.author', $user->getId()))
            ->addOrderBy('t.createdAt', 'DESC');

        return $this->paginate($qb, $page, Ticket::PER_PAGE);
    }

    public function findAllPaginatedByCategory(TicketCategory $ticketCategory)
    {
        return $this->findAll();
    }
}
