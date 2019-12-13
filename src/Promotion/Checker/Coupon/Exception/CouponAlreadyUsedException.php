<?php

namespace App\Promotion\Checker\Coupon\Exception;

class CouponAlreadyUsedException extends CouponException
{
    public $message = 'The coupon was already used.';

    public function getMessageKey(): string
    {
        return 'promotion_coupon_already_used';
    }
}
