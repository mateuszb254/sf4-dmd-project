<?php

namespace App\Promotion\Form\Transformer;

use App\Promotion\Entity\PromotionCoupon;
use App\Promotion\Repository\PromotionCouponRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CouponToStringTransformer implements DataTransformerInterface
{
    protected $couponRepository;

    public function __construct(PromotionCouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param PromotionCoupon $value
     * @return string
     */
    public function transform($value)
    {
        if (!$value instanceof PromotionCoupon) return '';

        return $value->getCode() ?? '';
    }

    public function reverseTransform($value)
    {
        $coupon = $this->couponRepository->findOneBy([
            'code' => $value
        ]);

        if (null === $coupon) {
            $transformationException = new TransformationFailedException('
                Coudn\'t transform ' . $value . ' to ' . PromotionCoupon::class
            );
            $transformationException->setInvalidMessage('promotion_coupon_not_found', [
                '%code%' => $value
            ]);

            throw $transformationException;
        }

        return $coupon;
    }
}
