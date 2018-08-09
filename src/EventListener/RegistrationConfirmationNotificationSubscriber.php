<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-28
 * Time: 15:44
 */

namespace App\EventListener;


use App\Entity\Registration;
use App\Events;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Message;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class RegistrationConfirmationNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $sender;
    private $twigEngine;

    /**
     * Constructor.
     *
     * @param \Swift_Mailer         $mailer
     * @param string                $sender
     */
    public function __construct(\Swift_Mailer $mailer, TwigEngine $twigEngine)
    {
        $this->mailer = $mailer;
        $this->twigEngine=$twigEngine;

    }
    public static function getSubscribedEvents()
    {
        return [
            Events::REGISTRATION_CONFIRMED => 'onRegistrationConfirmed',
        ];
    }
    /**
     * @param GenericEvent $event
     */
    public function onRegistrationConfirmed(GenericEvent $event, $user)
    {
        /** @var Registration $registration */

//        $email = $registration->getDog()->getOwner()->getUser()->getEmail();
        $message = (new Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('recipient@example.com')
            ->setBody(
                $this->twigEngine->render(
                // templates/emails/registration.html.twig
                    'confirmation.twig',
                    array('user' => $user)
                ),
                'text/html'
            );
        // In app/config/config_dev.yml the 'disable_delivery' option is set to 'true'.
        // That's why in the development environment you won't actually receive any email.
        // However, you can inspect the contents of those unsent emails using the debug toolbar.
        // See https://symfony.com/doc/current/email/dev_environment.html#viewing-from-the-web-debug-toolbar
        $this->mailer->send($message);
    }

}
