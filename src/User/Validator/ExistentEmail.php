<?php

namespace App\User\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class ExistentEmail extends Constraint
{
    public $message = 'email_nonexistent';
}
