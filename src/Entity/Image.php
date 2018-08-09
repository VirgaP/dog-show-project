<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\Table(name="images")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $fileName;

    /**
     * @var UploadedFile
     * @Assert\File(mimeTypes={"application/jpeg", "application/png", "application/pdf"})
     */
    private $file;
    /**
     * @ORM\ManyToOne(targetEntity="Dog", inversedBy="files")
     * @ORM\JoinColumn(name="dog_id", referencedColumnName="id")
     */
    private $dog;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Registration", mappedBy="files")
     */
    private $registrations;

//    public function __toString()
//    {
//        return(string) $this->fileName;
//    }

    public function __toString()
    {
        return '';
    }

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDog()
    {
        return $this->dog;
    }

    /**
     * @param mixed $dog
     */
    public function setDog($dog): void
    {
        $this->dog = $dog;
    }

    /**
     * @return mixed
     */
    public function getRegistration()
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration)
    {
        $this->registrations[] = $registration;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    public function getFileName()

    {
        return $this->fileName;
    }

    /**
     * @return $fileName
     */
    public function setFileName($fileName): ?string
    {
        $this->fileName = $fileName;
        return $fileName;
    }



}
