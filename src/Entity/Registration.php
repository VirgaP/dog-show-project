<?php

namespace App\Entity;

use App\Validation\UniqueDogInShow;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 * @ORM\Table(name="registrations")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueDogInShow(message="this dog is already registered,", groups={"Update"})
 */
class Registration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Registration to one Dog
     * @ORM\ManyToOne(targetEntity="Dog", inversedBy="registrations")
     * @ORM\JoinColumn(name="dog_id", referencedColumnName="id")
     */
    private $dog;
    /**
     * Many Registration to one Show
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="registrations")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id")
     */
   private $show;

    /**
     * Many Registration to one Class
     * @ORM\ManyToOne(targetEntity="ShowClass", fetch="EAGER")
     * @ORM\JoinColumn(name="show_class_id", referencedColumnName="id")
     */
   private $class;

    /**
     * Many Registrations have Many Competitions.
     * @ORM\ManyToMany(targetEntity="Competition", fetch="EXTRA_LAZY", orphanRemoval=true)
     * @ORM\JoinTable(name="registration_competitions",
     *      joinColumns={@ORM\JoinColumn(name="registration_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competition_id", referencedColumnName="id")}
     *      )
     */
   private $competitions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inCatalogue;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="App\Entity\Image", inversedBy="registrations", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="registrations_files")
     */
    private $files;

    /**
     * One Registration has One Diploma.
     * @ORM\OneToOne(targetEntity="Diploma", mappedBy="registration")
     */
    private $diploma;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    private $registrationDog;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
        $this->files =new ArrayCollection();
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
    public function getDog()
    {
        return $this->dog;
    }

    /**
     * @param mixed $dog
     * @return Registration
     */
    public function setDog($dog)
    {
        $this->dog = $dog;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * @param mixed $show
     * @return Registration
     */
    public function setShow($show)
    {
        $this->show = $show;
        return $this;
    }

    /**
     * @return mixed
     * @return Registration
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class): void
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getCompetitions()
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition):? ArrayCollection
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->setRegistration($this);
        }
        return $this->competitions;
    }

    public function removeCompetition(Competition $competition)
    {
        $this->competitions->removeElement($competition);

        return $this->competitions;
    }


    /**
     * @return mixed
     */
    public function getInCatalogue()
    {
        return $this->inCatalogue;
    }

    /**
     * @param mixed $inCatalogue
     */
    public function setInCatalogue($inCatalogue): void
    {
        $this->inCatalogue = $inCatalogue;
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
        $file->addRegistration($this); // synchronously updating inverse side
        $this->files[] = $file;
    }

    public function removeFile($file)
    {
        if (!$this->files->contains($file)) {
            return;
        }
        $this->files->removeElement($file);
    }

    /**
     * @return mixed
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * @param mixed $diploma
     */
    public function setDiploma($diploma): void
    {
        $this->diploma = $diploma;
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
     * @return mixed
     */
    public function getRegistrationDog()
    {
        return trim($this->getDog()->getRegisteredName(). ' '.$this->getShow()->getPlaceAndTime());
    }

    /**
     * @return mixed
     */
    public function getisConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @param mixed $isConfirmed
     */
    public function setIsConfirmed($isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
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
