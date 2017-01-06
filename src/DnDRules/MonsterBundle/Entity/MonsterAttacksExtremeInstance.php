<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MonsterAttacksExtremeInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstanceRepository")
 */
class MonsterAttacksExtremeInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="attackExtremeInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monsterAttackExtremeInstances;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\MonsterAttackInstance")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $attack;


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
     * Set number
     *
     * @param integer $number
     * @return MonsterAttacksExtremeInstance
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set attack
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attack
     * @return MonsterAttacksExtremeInstance
     */
    public function setAttack(\DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attack = null)
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * Get attack
     *
     * @return \DnDRules\MonsterBundle\Entity\MonsterAttackInstance 
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * Set monsterAttackExtremeInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterAttackExtremeInstances
     * @return MonsterAttacksExtremeInstance
     */
    public function setMonsterAttackExtremeInstances(\DnDRules\MonsterBundle\Entity\Monster $monsterAttackExtremeInstances)
    {
        $this->monsterAttackExtremeInstances = $monsterAttackExtremeInstances;

        return $this;
    }

    /**
     * Get monsterAttackExtremeInstances
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterAttackExtremeInstances()
    {
        return $this->monsterAttackExtremeInstances;
    }
}
