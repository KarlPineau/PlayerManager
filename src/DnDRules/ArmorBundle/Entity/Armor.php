<?php

namespace DnDRules\ArmorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Armor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ArmorBundle\Entity\ArmorRepository")
 * 
 * @UniqueEntity(fields="name", message="Une armure semble déjà porter ce nom ...")
 */
class Armor
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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "1",
     *      max = "45",
     *      minMessage = "Le champ 'Nom' doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le champ 'Nom' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Le champ 'Prix' ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\ArmorBundle\Entity\ArmorType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

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
     * @return Armor
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
     * Set slug
     *
     * @param string $slug
     * @return Armor
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Armor
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set bonus
     *
     * @param integer $bonus
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * Set type
     *
     * @param \DnDRules\ArmorBundle\Entity\ArmorType $type
     * @return Armor
     */
    public function setType(\DnDRules\ArmorBundle\Entity\ArmorType $type = null)
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return Armor
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
     * @return Armor
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
}
