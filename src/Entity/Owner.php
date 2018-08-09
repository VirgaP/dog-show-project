<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 * @ORM\Table(name="owners")
 * @ORM\HasLifecycleCallbacks()
 */
class Owner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * One Owner has One User.
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="owner")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 8,
     *      max = 15,
     *      minMessage = "Your phone number must be at least {{ 8 }} characters long",
     *      maxMessage = "Your phone number cannot be longer than {{ 15 }} characters"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * One Owner has Many Dogs.
     * @ORM\OneToMany(targetEntity="Dog", mappedBy="owner")
     */
    private $dogs;


    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __toString()
    {
        return '';
    }

    public function __construct() {
        $this->dogs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Owner
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

     /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getDogs()
    {
        return $this->dogs;
    }


    public function addDog(Dog $dog)
    {
        if (!$this->dogs->contains($dog)) {
            $this->dogs->add($dog);
            $dog->setOwner($this);
        }
        return $this->dogs;
    }

    public function removeDog($dog)
    {
//        foreach ($titles as $key => $title) {
        $this->dogs->removeElement($dog);
//        }
        return $this->dogs;
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
    public function getFullName()
    {
        return trim($this->getSurname(). ' '.$this->getName());
    }
}
