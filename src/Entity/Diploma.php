<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiplomaRepository")
 */
class Diploma
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $number;

    /**
     * One Diploma has One Registration.
     * @ORM\OneToOne(targetEntity="Registration", inversedBy="diploma")
     * @ORM\JoinColumn(name="registration_id", referencedColumnName="id")
     */
    private $registration;

    /**
     * One Diploma has One Result
     * @ORM\OneToOne(targetEntity="Result", mappedBy="diploma", cascade={"persist"})
     */
    private $result;

    /**
     * Many Diplomas have Many Titles.
     * @ORM\ManyToMany(targetEntity="Title")
     * @ORM\JoinTable(name="diploma_titles",
     *      joinColumns={@ORM\JoinColumn(name="diploma_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="title_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $titles;

    public function __construct()
    {
        $this->titles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @param mixed $registration
     */
    public function setRegistration($registration): void
    {
        $this->registration = $registration;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
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
        }
        return $this->titles;
    }

    public function removeTitle(Title $title)
    {
        if (!$this->titles->contains($title)) {
            return;
        }
        $this->titles->removeElement($title);

    }



}
