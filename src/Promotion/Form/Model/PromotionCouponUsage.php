<?php

namespace App\Promotion\Form\Model;

use App\Promotion\Entity\PromotionCoupon;
use App\Promotion\Validator as PromotionAsserts;
use Symfony\Component\Validator\Constraints as Assert;

class PromotionCouponUsage
{
    /**
     * @var PromotionCoupon|null
     *
     * @Assert\NotBlank()
     * @PromotionAsserts\PromotionCouponUsable(groups={"promotion_coupon_usable_check"})
     */
    protected $code;

    /**
     * @return PromotionCoupon|null
     */
    public function getCode(): ?PromotionCoupon
    {
        return $this->code;
    }

    /**
     * @param PromotionCoupon$code
     * @return self
     */
    public function setCode(PromotionCoupon $code): self
    {
        $this->code = $code;

        return $this;
    }
}
