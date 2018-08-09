<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-29
 * Time: 19:35
 */

namespace App;




final class Events
{
    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const REGISTRATION_CONFIRMED = 'registration.confirmed';
}
