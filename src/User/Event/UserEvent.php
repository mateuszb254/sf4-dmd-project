<?php

namespace App\User\Event;

use App\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    /** @var UserInterface $user */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
