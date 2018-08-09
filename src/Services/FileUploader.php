<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-21
 * Time: 15:40
 */

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function deleteFile()
    {
//        $fs = new Filesystem(); $fs->remove($this->get('kernel')->getRootDir().'/../public/uploads/images/'.$file);
        $fs = new Filesystem(); $fs->remove($this->getTargetDirectory()->file);
    }
}