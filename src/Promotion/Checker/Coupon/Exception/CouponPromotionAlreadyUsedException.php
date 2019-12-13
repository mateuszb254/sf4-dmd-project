<?php

namespace App\Promotion\Checker\Coupon\Exception;

class CouponPromotionAlreadyUsedException extends CouponException
{
    public $message = 'The promotion already expired';

    public function getMessageKey(): string
    {
        return 'promotion_coupon_one_per_tag';
    }
}
