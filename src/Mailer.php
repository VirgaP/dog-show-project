<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-29
 * Time: 20:53
 */

declare(strict_types=1);

namespace App;

use Twig\Environment;

class Mailer
{
    private $swiftMailer;
    private $twig;
    public function __construct(\Swift_Mailer $swiftMailer, Environment $twig)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }

    /**
     * @param string $recipient
     * @param array $data
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendRegistrationMail(string $recipient, array $data): void
    {
        $this->sendMail('confirmation.twig', $recipient, $data);
    }
    // way more mail functions...

    /**
     * @param string $template
     * @param string $recipient
     * @param array $data
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function sendMail(string $template, string $recipient, array $data): void
    {
        $template = $this->twig->load($template);
        $subject = $template->renderBlock('subject', $data);
        $htmlContent = $template->renderBlock('html_content', $data);
        $textContent = $template->renderBlock('text_content', $data);
        /** @var \Swift_Message $message */
        $message = $this->swiftMailer->createMessage();
        $message
            ->setTo($recipient)
            ->setFrom('noreply@example.org')
            ->setSubject($subject)
            ->setBody($textContent, 'text/plain')
            ->addPart($htmlContent, 'text/html');
        $this->swiftMailer->send($message);
    }
}