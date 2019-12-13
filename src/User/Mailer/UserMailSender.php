<?php

namespace App\User\Mailer;

use App\Core\Mailer\MailSender;

class UserMailSender extends MailSender implements UserMailSenderInterface
{
    public function sendEmailChangeTokenEmail(string $token, string $username, string $email): void
    {
        $this->sendEmailMessage(
            $this->twig->render('email/email_change_token.html.twig', [
                    'username' => $username,
                    'token' => $token
                ]
            ), $email);
    }

    public function sendResetPasswordTokenEmail(string $token, string $username, string $email): void
    {
        $this->sendEmailMessage(
            $this->twig->render('email/reset_password_token.html.twig', [
                    'username' => $username,
                    'token' => $token
                ]
            ), $email);
    }
}
