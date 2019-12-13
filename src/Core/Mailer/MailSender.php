<?php

namespace App\Core\Mailer;

use Twig\Environment;

abstract class MailSender
{
    /**
     * @var \Swift_Mailer $swiftMailer
     */
    protected $swiftMailer;

    /**
     * @var \Twig_Environment $twig
     */
    protected $twig;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $swiftMailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $swiftMailer, Environment $twig, string $string)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }


    /**
     * This method finally sends email with a passed message and a specified email address
     *
     * @param string $renderedTemplate
     * @param string $toEmail
     */
    protected function sendEmailMessage(string $renderedTemplate, string $toEmail): void
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = array_shift($renderedLines);
        $body = implode("\n", $renderedLines);

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($toEmail)
            ->setBody($body);

        $this->swiftMailer->send($message);
    }
}
