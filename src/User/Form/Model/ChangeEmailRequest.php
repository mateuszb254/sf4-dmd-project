<?php

namespace App\User\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangeEmailRequest
{
    /**
     * Represents user's password
     *
     * @var string|null $password
     *
     * @SecurityAssert\UserPassword()
     */
    private $password;

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
