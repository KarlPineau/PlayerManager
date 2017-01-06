<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MonsterAttackInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterAttackInstanceRepository")
 */
class MonsterAttackInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="attackInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monsterAttackInstances;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "1",
     *      max = "45",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="onlyExtreme", type="boolean", nullable=true, options={"default" = false})
     */
    private $onlyExtreme;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="bab", type="smallint")
     */
    private $bab;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\Weapon")
     * @ORM\JoinColumn(nullable=true)
     */
    private $weapon;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\DiceForm", mappedBy="monsterAttackDamage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $damageForms;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\Critical", mappedBy="monsterAttackCritic", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $damageCriticForms;

    /**
     * @var string
     * @Assert\Length(
     *      max = "1000",
     *      maxMessage = "Votre champ 'Effets secondaires' ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="damageSideEffect", type="text", nullable=true)
     */
    private $damageSideEffect;

    /**
     * @ORM\ManyToOne(targetEntity="CAS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $createUser;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createDate", type="datetime", nullable=false)
     */
    protected $createDate;

    /**
     * @ORM\ManyToOne(targetEntity="CAS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $updateUser;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateDate", type="datetime", nullable=true)
     */
    protected $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="updateComment", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le commentaire ne doit pas dépasser {{ limit }} caractères."
     * )
     */
    protected $updateComment;


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
     * Set name
     *
     * @param string $name
     * @return MonsterAttackInstance
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set bab
     *
     * @param integer $bab
     * @return MonsterAttackInstance
     */
    public function setBab($bab)
    {
        $this->bab = $bab;

        return $this;
    }

    /**
     * Get bab
     *
     * @return integer 
     */
    public function getBab()
    {
        return $this->bab;
    }

    /**
     * Set weapon
     *
     * @param \stdClass $weapon
     * @return MonsterAttackInstance
     */
    public function setWeapon($weapon)
    {
        $this->weapon = $weapon;

        return $this;
    }

    /**
     * Get weapon
     *
     * @return \stdClass 
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * Set damageForm
     *
     * @param \stdClass $damageForm
     * @return MonsterAttackInstance
     */
    public function setDamageForm($damageForm)
    {
        $this->damageForm = $damageForm;

        return $this;
    }

    /**
     * Get damageForm
     *
     * @return \stdClass 
     */
    public function getDamageForm()
    {
        return $this->damageForm;
    }

    /**
     * Set damageCriticForms
     *
     * @param \stdClass $damageCriticForms
     * @return MonsterAttackInstance
     */
    public function setDamageCriticForms($damageCriticForms)
    {
        $this->damageCriticForms = $damageCriticForms;

        return $this;
    }

    /**
     * Get damageCriticForms
     *
     * @return \stdClass 
     */
    public function getDamageCriticForms()
    {
        return $this->damageCriticForms;
    }

    /**
     * Set damageSideEffect
     *
     * @param string $damageSideEffect
     * @return MonsterAttackInstance
     */
    public function setDamageSideEffect($damageSideEffect)
    {
        $this->damageSideEffect = $damageSideEffect;

        return $this;
    }

    /**
     * Get damageSideEffect
     *
     * @return string 
     */
    public function getDamageSideEffect()
    {
        return $this->damageSideEffect;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return MonsterAttackInstance
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return MonsterAttackInstance
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set updateComment
     *
     * @param string $updateComment
     * @return MonsterAttackInstance
     */
    public function setUpdateComment($updateComment)
    {
        $this->updateComment = $updateComment;

        return $this;
    }

    /**
     * Get updateComment
     *
     * @return string 
     */
    public function getUpdateComment()
    {
        return $this->updateComment;
    }

    /**
     * Set monsterAttackInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterAttackInstances
     * @return MonsterAttackInstance
     */
    public function setMonsterAttackInstances(\DnDRules\MonsterBundle\Entity\Monster $monsterAttackInstances)
    {
        $this->monsterAttackInstances = $monsterAttackInstances;

        return $this;
    }

    /**
     * Get monsterAttackInstances
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterAttackInstances()
    {
        return $this->monsterAttackInstances;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return MonsterAttackInstance
     */
    public function setCreateUser(\CAS\UserBundle\Entity\User $createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return \CAS\UserBundle\Entity\User 
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }

    /**
     * Set updateUser
     *
     * @param \CAS\UserBundle\Entity\User $updateUser
     * @return MonsterAttackInstance
     */
    public function setUpdateUser(\CAS\UserBundle\Entity\User $updateUser = null)
    {
        $this->updateUser = $updateUser;

        return $this;
    }

    /**
     * Get updateUser
     *
     * @return \CAS\UserBundle\Entity\User 
     */
    public function getUpdateUser()
    {
        return $this->updateUser;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->damageForms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add damageForms
     *
     * @param \PM\HomeBundle\Entity\DiceForm $damageForms
     * @return MonsterAttackInstance
     */
    public function addDamageForm(\PM\HomeBundle\Entity\DiceForm $damageForms)
    {
        $this->damageForms[] = $damageForms;

        return $this;
    }

    /**
     * Remove damageForms
     *
     * @param \PM\HomeBundle\Entity\DiceForm $damageForms
     */
    public function removeDamageForm(\PM\HomeBundle\Entity\DiceForm $damageForms)
    {
        $this->damageForms->removeElement($damageForms);
    }

    /**
     * Get damageForms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDamageForms()
    {
        return $this->damageForms;
    }

    /**
     * Add damageCriticForms
     *
     * @param \PM\HomeBundle\Entity\Critical $damageCriticForms
     * @return MonsterAttackInstance
     */
    public function addDamageCriticForms(\PM\HomeBundle\Entity\Critical $damageCriticForms)
    {
        $this->damageCriticForms[] = $damageCriticForms;

        return $this;
    }

    /**
     * Remove damageCriticForms
     *
     * @param \PM\HomeBundle\Entity\Critical $damageCriticForms
     */
    public function removeDamageCriticForms(\PM\HomeBundle\Entity\Critical $damageCriticForms)
    {
        $this->damageCriticForms->removeElement($damageCriticForms);
    }

    /**
     * Set onlyExtreme
     *
     * @param boolean $onlyExtreme
     * @return MonsterAttackInstance
     */
    public function setOnlyExtreme($onlyExtreme)
    {
        $this->onlyExtreme = $onlyExtreme;

        return $this;
    }

    /**
     * Get onlyExtreme
     *
     * @return boolean 
     */
    public function getOnlyExtreme()
    {
        return $this->onlyExtreme;
    }

    /**
     * Add damageCriticForms
     *
     * @param \PM\HomeBundle\Entity\Critical $damageCriticForms
     * @return MonsterAttackInstance
     */
    public function addDamageCriticForm(\PM\HomeBundle\Entity\Critical $damageCriticForms)
    {
        $this->damageCriticForms[] = $damageCriticForms;

        return $this;
    }

    /**
     * Remove damageCriticForms
     *
     * @param \PM\HomeBundle\Entity\Critical $damageCriticForms
     */
    public function removeDamageCriticForm(\PM\HomeBundle\Entity\Critical $damageCriticForms)
    {
        $this->damageCriticForms->removeElement($damageCriticForms);
    }
}
