<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ShowRepository")
 * @ORM\Entity
 * @ORM\Table(name="`show`")
 */
class Show
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateShow;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $showName;

    /**
     * One Show has Many Registrations.
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="show")
     */
    private $registrations;

    private $placeAndTime;

    /**
     * Many Shows have Many Judges.
     * @ORM\ManyToMany(targetEntity="Judges", inversedBy="shows")
     * @ORM\JoinTable(name="shows_judges")
     */
    private $judges;

    public function __toString()
    {
        return '';
    }

    public function __construct() {
        $this->judges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->registrations = new ArrayCollection();
    }
    /**
     * @param $registrations
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDateShow()
    {
        return $this->dateShow;
    }

    /**
     * @param mixed $dateShow
     */
    public function setDateShow($dateShow): void
    {
        $this->dateShow = $dateShow;
    }

    public function setDateString(\DateTime $datetime){
        $this->dateShow = $datetime;
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
    public function getShowName()
    {
        return $this->showName;
    }

    /**
     * @param mixed $showName
     */
    public function setShowName($showName): void
    {
        $this->showName = $showName;
    }

    /**
     * @return mixed
     */
    public function getJudges()
    {
        return $this->judges;
    }


    public function addJudge(Judges $judge)
    {
//        $judge->addShow($this); // synchronously updating inverse side
        $this->judges[] = $judge;
    }

    public function removeJudge($judge)
    {
        if (!$this->judges->contains($judge)) {
            return;
        }
        $this->judges->removeElement($judge);
    }

    /**
     * @return mixed
     */
    public function getPlaceAndTime()
    {
        return $this->getCity() . ' '. '('. $this->dateShow->format('Y-m-d') . ')';
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
//        $judge->addShow($this); // synchronously updating inverse side
        $this->registrations[] = $registration;
    }

    public function removeRegistration($registration)
    {
        if (!$this->registrations->contains($registration)) {
            return;
        }
        $this->registrations->removeElement($registration);
    }

}
