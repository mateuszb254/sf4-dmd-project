<?php

namespace App\Promotion\Generator;

interface PromotionCouponGeneratorInterface
{
    public function generate(int $amount): array;
}
