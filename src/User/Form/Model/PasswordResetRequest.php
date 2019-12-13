<?php

namespace App\User\Form\Model;

use App\User\Validator as ProjectAssert;

class PasswordResetRequest
{
    /**
     * @var string|null
     *
     * @ProjectAssert\ExistentEmail()
     */
    private $email;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
