<?php

namespace App\Promotion\Repository;

use App\Core\Repository\ServiceEntityRepository;
use App\Promotion\Entity\Promotion;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    /**
     * Returns array with keys:
     *      'promotion' containing Promotion object
     *      'all_coupons_count' containing count of all coupons in Promotion
     *      'used_coupons_count' containing count of used coupons in Promotion
     *
     * @return array
     */
    public function findAllWithStatistics()
    {
        return $this->prepareFindAllPromotionsWithStatisticsQuery(false)->getResult();
    }

    /**
     * Returns array with keys:
     *      'promotion' containing Promotion object
     *      'all_coupons_count' containing count of all coupons in Promotion
     *      'used_coupons_count' containing count of used coupons in Promotion
     *
     * @return array
     */
    public function findAllActiveWithStatistics(): array
    {
        return $this->prepareFindAllPromotionsWithStatisticsQuery(true)->getResult();
    }

    protected function prepareFindAllPromotionsWithStatisticsQuery(bool $onlyActive): Query
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p as promotion, count(coupons) as all_coupons_count')
            ->addSelect("SUM(CASE WHEN(coupons.usedBy is not null) THEN 1 ELSE 0 END) as used_coupons_count")
            ->leftJoin('p.coupons', 'coupons')
            ->groupBy('p');

        if ($onlyActive) {
            $qb->where($qb->expr()->isNull('p.expires'))
                ->orWhere($qb->expr()->gt('p.expires', 'CURRENT_TIMESTAMP()'));
        }

        return $qb->getQuery();
    }
}
