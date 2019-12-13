<?php

namespace App\Promotion\Validator;

use App\Promotion\Checker\Coupon\CouponCheckerInterface;
use App\Promotion\Checker\Coupon\Exception\CouponException;
use App\Promotion\Entity\PromotionCoupon;
use App\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PromotionCouponUsableValidator extends ConstraintValidator
{
    /* @var CouponCheckerInterface */
    protected $couponChecker;

    /* @var TokenStorageInterface*/
    protected $tokenStorage;

    public function __construct(CouponCheckerInterface $couponChecker, TokenStorageInterface $tokenStorage)
    {
        $this->couponChecker = $couponChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function validate($value, Constraint $constraint)
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        if (!$value instanceof PromotionCoupon) {
            throw new \UnexpectedValueException(__CLASS__ . ' expects ' . PromotionCoupon::class . '.');
        }

        if (!$user instanceof UserInterface) {
            throw new \RuntimeException(__CLASS__ . ' needs an authenticated user.');
        }

        try {
            $this->couponChecker->check($value, $user);
        } catch (CouponException $couponException) {
            $this->context->buildViolation($couponException->getMessageKey())
                ->setParameter('%code%', $value->getCode())
                ->setParameter('%promotion_tag%', $value->getPromotion())
                ->addViolation();
        }
    }
}
