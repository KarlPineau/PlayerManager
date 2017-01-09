<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaceSkill
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\RaceBundle\Entity\RaceSkillRepository")
 */
class RaceSkill
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
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race", inversedBy="raceSkills")
     * @ORM\JoinColumn(nullable=true)
     */
    private $raceSkill;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SkillBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="smallint", nullable=false, options={"default" = 0})
     */
    private $value;


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
     * Set value
     *
     * @param integer $value
     * @return RaceSkill
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set race
     *
     * @param \DnDRules\RaceBundle\Entity\Race $race
     * @return RaceSkill
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
     * Set skill
     *
     * @param \DnDRules\SkillBundle\Entity\Skill $skill
     * @return RaceSkill
     */
    public function setSkill(\DnDRules\SkillBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \DnDRules\SkillBundle\Entity\Skill 
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set raceSkill
     *
     * @param \DnDRules\RaceBundle\Entity\Race $raceSkill
     * @return RaceSkill
     */
    public function setRaceSkill(\DnDRules\RaceBundle\Entity\Race $raceSkill = null)
    {
        $this->raceSkill = $raceSkill;

        return $this;
    }

    /**
     * Get raceSkill
     *
     * @return \DnDRules\RaceBundle\Entity\Race 
     */
    public function getRaceSkill()
    {
        return $this->raceSkill;
    }
}
