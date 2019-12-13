<?php

namespace App\User\Validator;

use App\User\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ExistentEmailValidator extends ConstraintValidator
{
    /** @var UserRepository $repository */
    private $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$user = $this->repository->findOneBy(['email' => $value])) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
