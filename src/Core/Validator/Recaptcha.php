<?php

namespace App\Core\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class Recaptcha extends Constraint
{
    public $message = 'recaptcha_invalid';
}
