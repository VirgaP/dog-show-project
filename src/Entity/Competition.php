<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionRepository")
 */
class Competition
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
    private $competitionTitle;

    public function __toString()
    {
        return '';
    }

    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @return mixed
//     */
//    public function getRegistration()
//    {
//        return $this->registration;
//    }
//
//    /**
//     * @param mixed $registration
//     */
//    public function setRegistration($registration): void
//    {
//        $this->registration = $registration;
//    }

    /**
     * @return mixed
     */
    public function getCompetitionTitle()
    {
        return $this->competitionTitle;
    }

    /**
     * @param mixed $competitionTitle
     */
    public function setCompetitionTitle($competitionTitle): void
    {
        $this->competitionTitle = $competitionTitle;
    }

}
