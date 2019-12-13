<?php

namespace App\Guild\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Guild\Entity\GuildMember;
use Doctrine\Common\Persistence\ManagerRegistry;

class GuildMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuildMember::class);
    }
}
