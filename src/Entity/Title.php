<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TitleRepository")
 * @ORM\Entity
 * @ORM\Table(name="title")
 */
class Title
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Dog", inversedBy="titles")
     * @ORM\JoinColumn(name="dog_id", referencedColumnName="id")
     */
    private $dog;

    public function __toString()
    {
        return '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
}
