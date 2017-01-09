<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RaceST
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\RaceBundle\Entity\RaceSTRepository")
 */
class RaceST
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
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race", inversedBy="levels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @var integer
     *
     * @ORM\Column(name="fortitude", type="smallint")
     */
    private $fortitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="reflex", type="smallint")
     */
    private $reflex;

    /**
     * @var integer
     *
     * @ORM\Column(name="will", type="smallint")
     */
    private $will;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre description des spécificités ne doit pas dépasser {{ limit }} caractères."
     * )
     * @ORM\Column(name="specificity", type="text", nullable=true)
     */
    private $specificity;


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
     * Set fortitude
     *
     * @param integer $fortitude
     * @return RaceST
     */
    public function setFortitude($fortitude)
    {
        $this->fortitude = $fortitude;

        return $this;
    }

    /**
     * Get fortitude
     *
     * @return integer 
     */
    public function getFortitude()
    {
        return $this->fortitude;
    }

    /**
     * Set reflex
     *
     * @param integer $reflex
     * @return RaceST
     */
    public function setReflex($reflex)
    {
        $this->reflex = $reflex;

        return $this;
    }

    /**
     * Get reflex
     *
     * @return integer 
     */
    public function getReflex()
    {
        return $this->reflex;
    }

    /**
     * Set will
     *
     * @param integer $will
     * @return RaceST
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return integer 
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set race
     *
     * @param \DnDRules\RaceBundle\Entity\Race $race
     * @return RaceST
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
     * Set specificity
     *
     * @param string $specificity
     * @return RaceST
     */
    public function setSpecificity($specificity)
    {
        $this->specificity = $specificity;

        return $this;
    }

    /**
     * Get specificity
     *
     * @return string 
     */
    public function getSpecificity()
    {
        return $this->specificity;
    }
}
