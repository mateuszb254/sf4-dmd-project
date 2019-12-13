<?php

namespace App\Promotion\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Promotion\Entity\Promotion;
use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class PromotionCouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionCoupon::class);
    }

    public function findOneByPromotionAndUser(Promotion $promotion, UserInterface $user): ?PromotionCoupon
    {
        return $this->findOneBy([
            'usedBy' => $user,
            'promotion' => $promotion
        ]);
    }

    public function findLatestPaginated(int $page = 1): array
    {
        $queryBuilder = $this->createQueryBuilder('u');

        return $this->paginate($queryBuilder, $page, PromotionCoupon::PER_PAGE);
    }
}
