<?php


namespace App\User\Mailer;


interface UserMailSenderInterface
{
    public function sendResetPasswordTokenEmail(string $token, string $username, string $email): void;
    public function sendEmailChangeTokenEmail(string $token, string $username, string $email): void;
}
