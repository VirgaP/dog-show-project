<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-19
 * Time: 10:38
 */

namespace App\EventListener;


use App\Event\SomeEvent;

class SomeEventListener
{
    public function onPageLoaded(SomeEvent $event)
    {
        $date = $event->getDate();

        echo $date->format('Y-m-d');
    }
}