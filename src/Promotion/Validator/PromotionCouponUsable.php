<?php

namespace App\Promotion\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PromotionCouponUsable extends Constraint
{
    public $message = 'The promotion code is not usable.';
}
