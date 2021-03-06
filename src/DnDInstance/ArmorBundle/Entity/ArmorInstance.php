<?php

namespace DnDInstance\ArmorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArmorInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\ArmorBundle\Entity\ArmorInstanceRepository")
 */
class ArmorInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ArmorBundle\Entity\Armor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $armor;

    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed")
     * @ORM\JoinColumn(nullable=true)
     */
    private $characterUsed;

    /**
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=true)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\ArmorBundle\Entity\ArmorType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $type;

    /**
     * @var string
     * @Assert\Length(
     *      min = "1",
     *      max = "45",
     *      minMessage = "Le champ 'Nom' doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le champ 'Nom' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wear", type="boolean", nullable=true, options={"default" = false})
     */
    private $wear;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le champ 'Valeur monétaire' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=true)
     */
    private $priceValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="bonus", type="integer", nullable=true)
     */
    private $bonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="dexterityBonus", type="integer", nullable=true)
     */
    private $dexterityBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="testMalus", type="integer", nullable=true)
     */
    private $testMalus;

    /**
     * @var integer
     *
     * @ORM\Column(name="failRisks", type="integer", nullable=true)
     */
    private $failRisks;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le champ 'Taille M' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="speedM", type="string", length=255, nullable=true)
     */
    private $speedM;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le champ 'Taille P' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="speedP", type="string", length=255, nullable=true)
     */
    private $speedP;

    /**
     * @var string
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "Le champ 'Poids' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="weight", type="string", length=50, nullable=true)
     */
    private $weight;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Le champ 'Description' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * Set name
     *
     * @param string $name
     * @return ArmorInstance
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
     * Set priceValue
     *
     * @param string $priceValue
     * @return ArmorInstance
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
     * Set bonus
     *
     * @param integer $bonus
     * @return ArmorInstance
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return integer 
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set dexterityBonus
     *
     * @param integer $dexterityBonus
     * @return ArmorInstance
     */
    public function setDexterityBonus($dexterityBonus)
    {
        $this->dexterityBonus = $dexterityBonus;

        return $this;
    }

    /**
     * Get dexterityBonus
     *
     * @return integer 
     */
    public function getDexterityBonus()
    {
        return $this->dexterityBonus;
    }

    /**
     * Set testMalus
     *
     * @param integer $testMalus
     * @return ArmorInstance
     */
    public function setTestMalus($testMalus)
    {
        $this->testMalus = $testMalus;

        return $this;
    }

    /**
     * Get testMalus
     *
     * @return integer 
     */
    public function getTestMalus()
    {
        return $this->testMalus;
    }

    /**
     * Set failRisks
     *
     * @param integer $failRisks
     * @return ArmorInstance
     */
    public function setFailRisks($failRisks)
    {
        $this->failRisks = $failRisks;

        return $this;
    }

    /**
     * Get failRisks
     *
     * @return integer 
     */
    public function getFailRisks()
    {
        return $this->failRisks;
    }

    /**
     * Set speedM
     *
     * @param string $speedM
     * @return ArmorInstance
     */
    public function setSpeedM($speedM)
    {
        $this->speedM = $speedM;

        return $this;
    }

    /**
     * Get speedM
     *
     * @return string 
     */
    public function getSpeedM()
    {
        return $this->speedM;
    }

    /**
     * Set speedP
     *
     * @param string $speedP
     * @return ArmorInstance
     */
    public function setSpeedP($speedP)
    {
        $this->speedP = $speedP;

        return $this;
    }

    /**
     * Get speedP
     *
     * @return string 
     */
    public function getSpeedP()
    {
        return $this->speedP;
    }

    /**
     * Set weight
     *
     * @param string $weight
     * @return ArmorInstance
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
     * Set description
     *
     * @param string $description
     * @return ArmorInstance
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * Set armor
     *
     * @param \DnDRules\ArmorBundle\Entity\Armor $armor
     * @return ArmorInstance
     */
    public function setArmor(\DnDRules\ArmorBundle\Entity\Armor $armor)
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get armor
     *
     * @return \DnDRules\ArmorBundle\Entity\Armor 
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return ArmorInstance
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * Set wear
     *
     * @param boolean $wear
     * @return ArmorInstance
     */
    public function setWear($wear)
    {
        $this->wear = $wear;

        return $this;
    }

    /**
     * Get wear
     *
     * @return boolean 
     */
    public function getWear()
    {
        return $this->wear;
    }

    /**
     * Set type
     *
     * @param \DnDRules\ArmorBundle\Entity\ArmorType $type
     * @return ArmorInstance
     */
    public function setType(\DnDRules\ArmorBundle\Entity\ArmorType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \DnDRules\ArmorBundle\Entity\ArmorType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return ArmorInstance
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
