<?php

namespace App\Promotion\Checker\Coupon\Exception;

class CouponExpiredException extends CouponException
{
    public $message = 'The coupon already expired.';

    public function getMessageKey(): string
    {
        return 'promotion_coupon_expired';
    }
}
