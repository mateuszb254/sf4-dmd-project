<?php

namespace App\Promotion\Checker\Coupon;

use App\Promotion\Entity\Promotion;
use App\Promotion\Repository\PromotionCouponRepository;
use App\Promotion\Checker\Coupon\Exception\CouponAlreadyUsedException;
use App\Promotion\Checker\Coupon\Exception\CouponExpiredException;
use App\Promotion\Checker\Coupon\Exception\CouponPromotionAlreadyUsedException;
use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;

class CouponChecker implements CouponCheckerInterface
{
    /** @var PromotionCouponRepository */
    protected $couponRepository;

    public function __construct(PromotionCouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param PromotionCoupon $coupon
     * @param UserInterface $user
     * @return bool
     * @throws CouponAlreadyUsedException
     * @throws CouponExpiredException
     * @throws CouponPromotionAlreadyUsedException
     */
    public function check(PromotionCoupon $coupon, UserInterface $user): bool
    {
        if ($this->isExpired($coupon)) {
            throw new CouponExpiredException($coupon);
        }

        if ($this->isUsed($coupon)) {
            throw new CouponAlreadyUsedException($coupon);
        }

        if ($this->isPromotionUsedByUser($coupon, $user)) {
            throw new CouponPromotionAlreadyUsedException($coupon);
        }

        return true;
    }

    /**
     * @param PromotionCoupon $coupon
     * @return bool
     */
    public function isExpired(PromotionCoupon $coupon): bool
    {
        /** @var Promotion $promotion */
        $promotion = $coupon->getPromotion();

        if (null === $promotion->getExpires()) return false;

        return $promotion->getExpires() <= new \DateTime();
    }

    /**
     * @param PromotionCoupon $coupon
     * @return bool
     */
    public function isUsed(PromotionCoupon $coupon): bool
    {
        return $coupon->getUsedBy() !== null;
    }

    /**
     * @param PromotionCoupon $coupon
     * @param UserInterface $user
     * @return bool
     */
    public function isPromotionUsedByUser(PromotionCoupon $coupon, UserInterface $user): bool
    {
        /** @var Promotion $promotion */
        $promotion = $coupon->getPromotion();

        if ($promotion->getType() !== Promotion::ONE_PER_USER_TYPE) return false;

        return $this->couponRepository->findOneByPromotionAndUser($coupon->getPromotion(), $user) instanceof PromotionCoupon;
    }
}
