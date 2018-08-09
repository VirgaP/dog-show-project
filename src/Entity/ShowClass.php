<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ShowClassRepository")
 */
class ShowClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $classTitle;

    public function __toString()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getClassTitle()
    {
        return $this->classTitle;
    }

    /**
     * @param mixed $classTitle
     */
    public function setClassTitle($classTitle)
    {
        $this->classTitle = $classTitle;
    }


    public function getId()
    {
        return $this->id;
    }




}
