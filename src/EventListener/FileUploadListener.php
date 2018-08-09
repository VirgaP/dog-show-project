<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-06
 * Time: 20:23
 */

namespace App\EventListener;


use App\Entity\Image;
use App\Entity\Registration;
use App\Services\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadListener
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
        // upload only works for Product entities
        if (!$entity instanceof Image) {
            return;
        }

        $file = $entity->getFile();

        // only upload new files
        if ($file instanceof UploadedFile) {
//            $fileName = $this->uploader->upload($file->getFilename());
//            $fileName = $fileUploader->upload($file->getFile());
            $fileName = $this->uploader->upload($file);
            $entity->setFileName($fileName);
        }
    }
}