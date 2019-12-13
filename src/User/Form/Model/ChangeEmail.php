<?php

namespace App\User\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangeEmail
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
     * @var string|null $newPassword
     *
     * @Assert\NotBlank()
     */
    private $newEmail;

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

    /**
     * @return string|null
     */
    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    /**
     * @param string $newEmail
     *
     * @return self
     */
    public function setNewEmail(string $newEmail): self
    {
        $this->newEmail = $newEmail;

        return $this;
    }
}
