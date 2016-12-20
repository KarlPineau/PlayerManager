<?php

namespace PM\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DiceForm
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PM\HomeBundle\Entity\DiceFormRepository")
 */
class DiceForm
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
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\DiceEntity", mappedBy="diceForm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $diceEntities;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\BonusNumber", mappedBy="diceForm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $bonusNumbers;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\WeaponDamage", inversedBy="damages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $weaponDamage;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="hpForm")
     * @ORM\JoinColumn(nullable=true)
     */
    private $monsterHpForm;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createDate", type="datetime", nullable=false)
     */
    protected $createDate;
    
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
        $this->diceEntities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bonusNumbers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return DiceForm
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Add diceEntities
     *
     * @param \PM\HomeBundle\Entity\DiceEntity $diceEntities
     * @return DiceForm
     */
    public function addDiceEntity(\PM\HomeBundle\Entity\DiceEntity $diceEntities)
    {
        $this->diceEntities[] = $diceEntities;

        return $this;
    }

    /**
     * Remove diceEntities
     *
     * @param \PM\HomeBundle\Entity\DiceEntity $diceEntities
     */
    public function removeDiceEntity(\PM\HomeBundle\Entity\DiceEntity $diceEntities)
    {
        $this->diceEntities->removeElement($diceEntities);
    }

    /**
     * Get diceEntities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDiceEntities()
    {
        return $this->diceEntities;
    }

    /**
     * Add bonusNumbers
     *
     * @param \PM\HomeBundle\Entity\BonusNumber $bonusNumbers
     * @return DiceForm
     */
    public function addBonusNumber(\PM\HomeBundle\Entity\BonusNumber $bonusNumbers)
    {
        $this->bonusNumbers[] = $bonusNumbers;

        return $this;
    }

    /**
     * Remove bonusNumbers
     *
     * @param \PM\HomeBundle\Entity\BonusNumber $bonusNumbers
     */
    public function removeBonusNumber(\PM\HomeBundle\Entity\BonusNumber $bonusNumbers)
    {
        $this->bonusNumbers->removeElement($bonusNumbers);
    }

    /**
     * Get bonusNumbers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBonusNumbers()
    {
        return $this->bonusNumbers;
    }

    /**
     * Set weaponDamage
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponDamage $weaponDamage
     * @return DiceForm
     */
    public function setWeaponDamage(\DnDRules\WeaponBundle\Entity\WeaponDamage $weaponDamage = null)
    {
        $this->weaponDamage = $weaponDamage;

        return $this;
    }

    /**
     * Get weaponDamage
     *
     * @return \DnDRules\WeaponBundle\Entity\WeaponDamage 
     */
    public function getWeaponDamage()
    {
        return $this->weaponDamage;
    }

    /**
     * Set monsterHpForm
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterHpForm
     * @return DiceForm
     */
    public function setMonsterHpForm(\DnDRules\MonsterBundle\Entity\Monster $monsterHpForm = null)
    {
        $this->monsterHpForm = $monsterHpForm;

        return $this;
    }

    /**
     * Get monsterHpForm
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterHpForm()
    {
        return $this->monsterHpForm;
    }
}
