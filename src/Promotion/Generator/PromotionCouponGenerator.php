<?php

namespace App\Promotion\Generator;

use App\Core\Generator\UniquenessGeneratorInterface;
use App\Promotion\Entity\PromotionCoupon;

final class PromotionCouponGenerator implements PromotionCouponGeneratorInterface
{
    private $uniqueGenerator;

    public function __construct(UniquenessGeneratorInterface $uniqueGenerator)
    {
        $this->uniqueGenerator = $uniqueGenerator;
    }

    public function generate(int $amount): array
    {
        $generatedAt = new \DateTime();

        $promotionalCodes = [];

        for ($i = 0; $i < $amount; $i++) {
            $promotionCoupon = new PromotionCoupon();

            do {
                $promotionCoupon->setCode($this->uniqueGenerator->generate());
            } while (in_array($promotionCoupon, $promotionalCodes));

            $promotionCoupon->setGeneratedAt($generatedAt);

            $promotionalCodes[] = $promotionCoupon;
        }

        return $promotionalCodes;
    }
}
