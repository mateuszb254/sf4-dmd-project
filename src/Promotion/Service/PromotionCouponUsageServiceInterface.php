<?php

namespace App\Promotion\Service;

use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;

interface PromotionCouponUsageServiceInterface
{
    public function useCoupon(PromotionCoupon $coupon, UserInterface $user);
}
