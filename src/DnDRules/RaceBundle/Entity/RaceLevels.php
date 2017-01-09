<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaceLevels
 *
 * @ORM\Entity(repositoryClass="DnDRules\RaceBundle\Entity\RaceLevelsRepository")
 */
class RaceLevels
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
     * @ORM\OneToMany(targetEntity="DnDRules\RaceBundle\Entity\RaceLevel", mappedBy="raceLevel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $raceLevels;


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
        $this->raceLevels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add raceLevels
     *
     * @param \DnDRules\RaceBundle\Entity\RaceLevel $raceLevels
     * @return RaceLevels
     */
    public function addRaceLevel(\DnDRules\RaceBundle\Entity\RaceLevel $raceLevels)
    {
        $this->raceLevels[] = $raceLevels;

        return $this;
    }

    /**
     * Remove raceLevels
     *
     * @param \DnDRules\RaceBundle\Entity\RaceLevel $raceLevels
     */
    public function removeRaceLevel(\DnDRules\RaceBundle\Entity\RaceLevel $raceLevels)
    {
        $this->raceLevels->removeElement($raceLevels);
    }

    /**
     * Get raceLevels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRaceLevels()
    {
        return $this->raceLevels;
    }
}
