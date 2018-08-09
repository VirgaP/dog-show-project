<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DogRepository")
 * @ORM\Table(name="dogs")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("pedigree_reg_no")
 */
class Dog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"registration"}, message="This dog has already been registered to the show")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $registered_name;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotBlank()
     */
    private $pedigree_reg_no;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_birth;

    /**
     * @ORM\OneToMany(targetEntity="Title", mappedBy="dog", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $titles;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $chip_tattoo_no;

    /**
     * @ORM\Column(type="string")
     */
    private $sire;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $dam;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $breeder;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name_of_club;

    /**
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="dogs")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="dog", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $files;

    /**
     * Many Registration to one Dog
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="dog")
     */
    private $registrations;

    public function __construct()
    {
        $this->titles = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    public function __toString()
    {
        return '';

    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRegisteredName()
    {
        return $this->registered_name;
    }

    /**
     * @param mixed $registered_name
     */
    public function setRegisteredName($registered_name): void
    {
        $this->registered_name = $registered_name;
    }

    /**
     * @return mixed
     */
    public function getPedigreeRegNo()
    {
        return $this->pedigree_reg_no;
    }

    /**
     * @param mixed $pedigree_reg_no
     */
    public function setPedigreeRegNo($pedigree_reg_no): void
    {
        $this->pedigree_reg_no = $pedigree_reg_no;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getTitles()
    {
        return $this->titles;
    }


    public function addTitle(Title $title)
    {
       if (!$this->titles->contains($title)) {
            $this->titles->add($title);
            $title->setDog($this);
        }
        return $this->titles;
    }

    public function removeTitle(Title $title)
    {
        if (!$this->titles->contains($title)) {
            return;
        }
        $this->titles->removeElement($title);
        // needed to update the owning side of the relationship!
        $title->setDog(null);
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }


    public function addFile(Image $file)
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setDog($this);
        }
        return $this->files;
    }

    public function removeFile($file)
    {
//        foreach ($titles as $key => $title) {
        $this->files->removeElement($file);
//        }
        return $this->files;

    }

    /**
     * @return mixed
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration)
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setDog($this);
        }
        return $this->registrations;
    }

    public function removeRegistration($registration)
    {
//        foreach ($titles as $key => $title) {
        $this->registrations->removeElement($registration);
//        }
        return $this->registrations;

    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @param mixed $date_of_birth
     */
    public function setDateOfBirth($date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }


    /**
     * @return mixed
     */
    public function getChipTattooNo()
    {
        return $this->chip_tattoo_no;
    }

    /**
     * @param mixed $chip_tattoo_no
     */
    public function setChipTattooNo($chip_tattoo_no): void
    {
        $this->chip_tattoo_no = $chip_tattoo_no;
    }

    /**
     * @return mixed
     */
    public function getSire()
    {
        return $this->sire;
    }

    /**
     * @param mixed $sire
     */
    public function setSire($sire): void
    {
        $this->sire = $sire;
    }

    /**
     * @return mixed
     */
    public function getDam()
    {
        return $this->dam;
    }

    /**
     * @param mixed $dam
     */
    public function setDam($dam): void
    {
        $this->dam = $dam;
    }

    /**
     * @return mixed
     */
    public function getBreeder()
    {
        return $this->breeder;
    }

    /**
     * @param mixed $breeder
     */
    public function setBreeder($breeder): void
    {
        $this->breeder = $breeder;
    }

    /**
     * @return mixed
     */
    public function getNameOfClub()
    {
        return $this->name_of_club;
    }

    /**
     * @param mixed $name_of_club
     */
    public function setNameOfClub($name_of_club): void
    {
        $this->name_of_club = $name_of_club;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamps()
    {
        $this->updated_at = new \DateTime('now');

        if ($this->getCreatedAt() === null) {
            $this->created_at = new \DateTime('now');
        }
    }


}
