<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-21
 * Time: 16:46
 */

namespace App\EventListener;

use App\Entity\Image;
use App\Entity\Registration;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Dog;



class ImageUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }


    private function uploadFile($entity)
    {

        if (!$entity instanceof Image) {
            return;
        }

        $file = $entity->getFile();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setFileName($fileName);
        }
    }


    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Image) {
            return;
        }

        if ($fileName = $entity->getFile()) {
            $entity->setFile(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }
}