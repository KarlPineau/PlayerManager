<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaceLevels
 *
 * @ORM\Entity()
 */
class RaceSkills
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
     * @ORM\OneToMany(targetEntity="DnDRules\RaceBundle\Entity\RaceSkill", mappedBy="raceSkill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $raceSkills;


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
     * Constructor
     */
    public function __construct()
    {
        $this->raceSkills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add raceSkills
     *
     * @param \DnDRules\RaceBundle\Entity\RaceSkill $raceSkills
     * @return RaceSkills
     */
    public function addRaceSkill(\DnDRules\RaceBundle\Entity\RaceSkill $raceSkills)
    {
        $this->raceSkills[] = $raceSkills;

        return $this;
    }

    /**
     * Remove raceSkills
     *
     * @param \DnDRules\RaceBundle\Entity\RaceSkill $raceSkills
     */
    public function removeRaceSkill(\DnDRules\RaceBundle\Entity\RaceSkill $raceSkills)
    {
        $this->raceSkills->removeElement($raceSkills);
    }

    /**
     * Get raceSkills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRaceSkills()
    {
        return $this->raceSkills;
    }
}
