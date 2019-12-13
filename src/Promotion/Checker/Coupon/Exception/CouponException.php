<?php

namespace App\Promotion\Checker\Coupon\Exception;

use App\Promotion\Entity\PromotionCoupon;
use Throwable;

abstract class CouponException extends \Exception
{
    /** @var PromotionCoupon $promotionCoupon */
    protected $promotionCoupon;

    public function __construct(PromotionCoupon $coupon, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->promotionCoupon = $coupon;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return PromotionCoupon
     */
    public function getCoupon(): PromotionCoupon
    {
        return $this->promotionCoupon;
    }

    abstract public function getMessageKey(): string;
}
