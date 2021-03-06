<?php

namespace DnDInstance\WeaponBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WeaponInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\WeaponBundle\Entity\WeaponInstanceRepository")
 */
class WeaponInstance
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
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre description ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\Weapon")
     * @ORM\JoinColumn(nullable=false)
     */
    private $weapon;

    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed")
     * @ORM\JoinColumn(nullable=true)
     */
    private $characterUsed;

    /**
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game", inversedBy="weaponInstances")
     * @ORM\JoinColumn(nullable=true)
     */
    private $game;

    /**
     * @var string
     * @Assert\Length(
     *      max = "100",
     *      maxMessage = "Votre prix ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="priceValue", type="text", nullable=true)
     */
    private $priceValue;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10",
     *      maxMessage = "Votre facteur de portée ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="scope", type="text", nullable=true)
     */
    private $scope;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10",
     *      maxMessage = "Votre poids ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="weight", type="text", nullable=true)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\WeaponBundle\Entity\WeaponDamage", mappedBy="weaponInstance", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $damages;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\Critical", mappedBy="weaponInstance", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $criticals;

    /**
     * @var integer
     * Nombre de mains nécessaire pour tenir l'arme
     *
     * @ORM\Column(name="handsNumber", type="integer", nullable=true, options={"default" = 1})
     */
    private $handsNumber;

    /**
     * @var integer
     * @ORM\Column(name="weaponCategory", type="integer", nullable=true)
     */
    private $weaponCategory;


    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\WeaponType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $weaponType;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->damages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criticals = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return WeaponInstance
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
     * Set description
     *
     * @param string $description
     * @return WeaponInstance
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set priceValue
     *
     * @param string $priceValue
     * @return WeaponInstance
     */
    public function setPriceValue($priceValue)
    {
        $this->priceValue = $priceValue;

        return $this;
    }

    /**
     * Get priceValue
     *
     * @return string 
     */
    public function getPriceValue()
    {
        return $this->priceValue;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return WeaponInstance
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string 
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set weight
     *
     * @param string $weight
     * @return WeaponInstance
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set handsNumber
     *
     * @param integer $handsNumber
     * @return WeaponInstance
     */
    public function setHandsNumber($handsNumber)
    {
        $this->handsNumber = $handsNumber;

        return $this;
    }

    /**
     * Get handsNumber
     *
     * @return integer 
     */
    public function getHandsNumber()
    {
        return $this->handsNumber;
    }

    /**
     * Set weaponCategory
     *
     * @param integer $weaponCategory
     * @return WeaponInstance
     */
    public function setWeaponCategory($weaponCategory)
    {
        $this->weaponCategory = $weaponCategory;

        return $this;
    }

    /**
     * Get weaponCategory
     *
     * @return integer 
     */
    public function getWeaponCategory()
    {
        return $this->weaponCategory;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return WeaponInstance
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
     * @return WeaponInstance
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
     * Set weapon
     *
     * @param \DnDRules\WeaponBundle\Entity\Weapon $weapon
     * @return WeaponInstance
     */
    public function setWeapon(\DnDRules\WeaponBundle\Entity\Weapon $weapon)
    {
        $this->weapon = $weapon;

        return $this;
    }

    /**
     * Get weapon
     *
     * @return \DnDRules\WeaponBundle\Entity\Weapon 
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return WeaponInstance
     */
    public function setGame(\Game\GameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \Game\GameBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add damages
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponDamage $damages
     * @return WeaponInstance
     */
    public function addDamage(\DnDRules\WeaponBundle\Entity\WeaponDamage $damages)
    {
        $this->damages[] = $damages;

        return $this;
    }

    /**
     * Remove damages
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponDamage $damages
     */
    public function removeDamage(\DnDRules\WeaponBundle\Entity\WeaponDamage $damages)
    {
        $this->damages->removeElement($damages);
    }

    /**
     * Get damages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDamages()
    {
        return $this->damages;
    }

    /**
     * Add criticals
     *
     * @param \PM\HomeBundle\Entity\Critical $criticals
     * @return WeaponInstance
     */
    public function addCritical(\PM\HomeBundle\Entity\Critical $criticals)
    {
        $this->criticals[] = $criticals;

        return $this;
    }

    /**
     * Remove criticals
     *
     * @param \PM\HomeBundle\Entity\Critical $criticals
     */
    public function removeCritical(\PM\HomeBundle\Entity\Critical $criticals)
    {
        $this->criticals->removeElement($criticals);
    }

    /**
     * Get criticals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriticals()
    {
        return $this->criticals;
    }

    /**
     * Set weaponType
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponType $weaponType
     * @return WeaponInstance
     */
    public function setWeaponType(\DnDRules\WeaponBundle\Entity\WeaponType $weaponType = null)
    {
        $this->weaponType = $weaponType;

        return $this;
    }

    /**
     * Get weaponType
     *
     * @return \DnDRules\WeaponBundle\Entity\WeaponType 
     */
    public function getWeaponType()
    {
        return $this->weaponType;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return WeaponInstance
     */
    public function setCreateUser(\CAS\UserBundle\Entity\User $createUser = null)
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
     * @return WeaponInstance
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
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return WeaponInstance
     */
    public function setCharacterUsed(\DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed = null)
    {
        $this->characterUsed = $characterUsed;

        return $this;
    }

    /**
     * Get characterUsed
     *
     * @return \DnDInstance\CharacterBundle\Entity\CharacterUsed 
     */
    public function getCharacterUsed()
    {
        return $this->characterUsed;
    }
}
