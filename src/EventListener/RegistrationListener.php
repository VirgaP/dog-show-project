<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-07-05
 * Time: 16:01
 */

namespace App\EventListener;


use App\Entity\Registration;
use App\Services\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;

class RegistrationListener
{
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->handleEvent($eventArgs);
    }

    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
    $this->handleEvent($eventArgs);
    }

    private function handleEvent(LifecycleEventArgs $eventArgs)
    {
        $registration = $eventArgs->getEntity();

        if ($registration instanceof Registration) {
                $dog = $registration->getDog();
                $show = $registration->getShow();
//                $file = $registration->getFiles();


            if (!is_null($registration)) {
                $registration->setDog($dog);
                $registration->setShow($show);
//                $registration->addFile($file);

            }
        }
    }
}