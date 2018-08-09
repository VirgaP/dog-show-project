<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $grade;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $place;

    /**
     * One Result has One Diploma.
     * @ORM\OneToOne(targetEntity="Diploma", inversedBy="result")
     * @ORM\JoinColumn(name="diploma_id", referencedColumnName="id")
     */
    private $diploma;

    public function getId()
    {
        return $this->id;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(?int $place): self
    {
        $this->place = $place;

        return $this;
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



}
