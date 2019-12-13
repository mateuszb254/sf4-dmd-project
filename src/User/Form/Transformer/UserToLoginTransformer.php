<?php

namespace App\User\Form\Transformer;

use App\User\Model\UserInterface;
use App\User\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserToLoginTransformer implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * LoginToUserTransformer constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function transform($value)
    {
        if (!$value instanceof UserInterface) return '';

        return $value->getLogin();
    }

    public function reverseTransform($value)
    {
        /** @var UserInterface|null $user */
        if (!$user = $this->userRepository->findOneBy(['login' => $value])) {
            $transformationFailedException = new TransformationFailedException(sprintf(
                    'An user with login %s not found. Transformer: %s', $value, __CLASS__)
            );

            $transformationFailedException->setInvalidMessage('user_login_not_found');

            throw $transformationFailedException;
        }


        return $user;
    }
}
