<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaceLevel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\RaceBundle\Entity\RaceLevelRepository")
 */
class RaceLevel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race", inversedBy="raceLevels")
     * @ORM\JoinColumn(nullable=true)
     */
    private $raceLevel;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gift", type="boolean")
     */
    private $gift;

    /**
     * @var integer
     *
     * @ORM\Column(name="additionalSkillPoints", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $additionalSkillPoints;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gift
     *
     * @param boolean $gift
     * @return RaceLevel
     */
    public function setGift($gift)
    {
        $this->gift = $gift;

        return $this;
    }

    /**
     * Get gift
     *
     * @return boolean 
     */
    public function getGift()
    {
        return $this->gift;
    }

    /**
     * Set additionalSkillPoints
     *
     * @param integer $additionalSkillPoints
     * @return RaceLevel
     */
    public function setAdditionalSkillPoints($additionalSkillPoints)
    {
        $this->additionalSkillPoints = $additionalSkillPoints;

        return $this;
    }

    /**
     * Get additionalSkillPoints
     *
     * @return integer 
     */
    public function getAdditionalSkillPoints()
    {
        return $this->additionalSkillPoints;
    }

    /**
     * Set race
     *
     * @param \DnDRules\RaceBundle\Entity\Race $race
     * @return RaceLevel
     */
    public function setRace(\DnDRules\RaceBundle\Entity\Race $race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return \DnDRules\RaceBundle\Entity\Race 
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set level
     *
     * @param \DnDRules\LevelBundle\Entity\Level $level
     * @return RaceLevel
     */
    public function setLevel(\DnDRules\LevelBundle\Entity\Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \DnDRules\LevelBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set raceLevel
     *
     * @param \DnDRules\RaceBundle\Entity\Race $raceLevel
     * @return RaceLevel
     */
    public function setRaceLevel(\DnDRules\RaceBundle\Entity\Race $raceLevel = null)
    {
        $this->raceLevel = $raceLevel;

        return $this;
    }

    /**
     * Get raceLevel
     *
     * @return \DnDRules\RaceBundle\Entity\Race 
     */
    public function getRaceLevel()
    {
        return $this->raceLevel;
    }
}
