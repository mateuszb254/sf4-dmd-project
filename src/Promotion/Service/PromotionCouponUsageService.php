<?php

namespace App\Promotion\Service;

use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;

class PromotionCouponUsageService implements PromotionCouponUsageServiceInterface
{
    public function useCoupon(PromotionCoupon $coupon, UserInterface $user): void
    {
        $user->addCoins($coupon->getPromotion()->getCoins());
        $coupon->setUsedBy($user);
        $coupon->setUsedAt(new \DateTime());
    }
}
