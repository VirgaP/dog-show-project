<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JudgesRepository")
 */
class Judges
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;
    /**
     * Many Judges have Many Shows.
     * @ORM\ManyToMany(targetEntity="Show", mappedBy="judges", cascade={"persist"})
     */
    private $shows;

    private $fullName;

    public function __toString()
    {
        return '';
    }
    public function __construct() {
        $this->shows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShows()
    {
        return $this->shows;
    }


    public function addShow(Show $show)
    {
        $this->shows[] = $show;
    }

    public function getFullName()
    {
        return trim($this->getName(). ' '.$this->getSurname());
    }


}
