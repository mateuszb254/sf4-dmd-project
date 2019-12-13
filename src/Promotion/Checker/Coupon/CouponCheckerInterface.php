<?php

namespace App\Promotion\Checker\Coupon;

use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;

interface CouponCheckerInterface
{
    public function check(PromotionCoupon $coupon, UserInterface $user);
}
