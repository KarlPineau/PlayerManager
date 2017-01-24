<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * classDnD
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ClassDnDBundle\Entity\ClassDnDRepository")
 * 
 * @UniqueEntity(fields="name", message="Cette classe existe déjà.")
 */
class ClassDnD
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
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45)
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
     *      max = "100000",
     *      maxMessage = "Votre description ne doit pas dépasser {{ limit }} caractères."
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnDLevel", mappedBy="classDnD", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $levels;
    
    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\SkillBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=true)
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\WeaponBundle\Entity\WeaponType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $allowWeaponType;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\ArmorBundle\Entity\ArmorType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $allowArmorType;

    /**
     * @ORM\ManyToOne(targetEntity="PM\HomeBundle\Entity\DiceType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $diceHealth;

    /**
     * @var integer
     *
     * @ORM\Column(name="pointsSkillByLevel", type="integer")
     */
    private $pointsSkillByLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="pointsSkillFirstLevel", type="integer")
     */
    private $pointsSkillFirstLevel;

    /**
     * @ORM\ManyToOne(targetEntity="CAS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ClassDnD
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
     * @return ClassDnD
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
     * Set description
     *
     * @param string $description
     * @return ClassDnD
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
     * @return ClassDnD
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
     * @return ClassDnD
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
     * Add levels
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $levels
     * @return ClassDnD
     */
    public function addLevel(\DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $levels)
    {
        $this->levels[] = $levels;

        return $this;
    }

    /**
     * Remove levels
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $levels
     */
    public function removeLevel(\DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $levels)
    {
        $this->levels->removeElement($levels);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Add skills
     *
     * @param \DnDRules\SkillBundle\Entity\Skill $skills
     * @return ClassDnD
     */
    public function addSkill(\DnDRules\SkillBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param \DnDRules\SkillBundle\Entity\Skill $skills
     */
    public function removeSkill(\DnDRules\SkillBundle\Entity\Skill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassDnD
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
     * @return ClassDnD
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
     * Set diceHealth
     *
     * @param \PM\HomeBundle\Entity\DiceType $diceHealth
     * @return ClassDnD
     */
    public function setDiceHealth(\PM\HomeBundle\Entity\DiceType $diceHealth = null)
    {
        $this->diceHealth = $diceHealth;

        return $this;
    }

    /**
     * Get diceHealth
     *
     * @return \PM\HomeBundle\Entity\DiceType 
     */
    public function getDiceHealth()
    {
        return $this->diceHealth;
    }

    /**
     * Set pointsSkillByLevel
     *
     * @param integer $pointsSkillByLevel
     * @return ClassDnD
     */
    public function setPointsSkillByLevel($pointsSkillByLevel)
    {
        $this->pointsSkillByLevel = $pointsSkillByLevel;

        return $this;
    }

    /**
     * Get pointsSkillByLevel
     *
     * @return integer 
     */
    public function getPointsSkillByLevel()
    {
        return $this->pointsSkillByLevel;
    }

    /**
     * Set pointsSkillFirstLevel
     *
     * @param integer $pointsSkillFirstLevel
     * @return ClassDnD
     */
    public function setPointsSkillFirstLevel($pointsSkillFirstLevel)
    {
        $this->pointsSkillFirstLevel = $pointsSkillFirstLevel;

        return $this;
    }

    /**
     * Get pointsSkillFirstLevel
     *
     * @return integer 
     */
    public function getPointsSkillFirstLevel()
    {
        return $this->pointsSkillFirstLevel;
    }

    /**
     * Add allowWeaponType
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponType $allowWeaponType
     * @return ClassDnD
     */
    public function addAllowWeaponType(\DnDRules\WeaponBundle\Entity\WeaponType $allowWeaponType)
    {
        $this->allowWeaponType[] = $allowWeaponType;

        return $this;
    }

    /**
     * Remove allowWeaponType
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponType $allowWeaponType
     */
    public function removeAllowWeaponType(\DnDRules\WeaponBundle\Entity\WeaponType $allowWeaponType)
    {
        $this->allowWeaponType->removeElement($allowWeaponType);
    }

    /**
     * Get allowWeaponType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAllowWeaponType()
    {
        return $this->allowWeaponType;
    }

    /**
     * Add allowArmorType
     *
     * @param \DnDRules\ArmorBundle\Entity\ArmorType $allowArmorType
     * @return ClassDnD
     */
    public function addAllowArmorType(\DnDRules\ArmorBundle\Entity\ArmorType $allowArmorType)
    {
        $this->allowArmorType[] = $allowArmorType;

        return $this;
    }

    /**
     * Remove allowArmorType
     *
     * @param \DnDRules\ArmorBundle\Entity\ArmorType $allowArmorType
     */
    public function removeAllowArmorType(\DnDRules\ArmorBundle\Entity\ArmorType $allowArmorType)
    {
        $this->allowArmorType->removeElement($allowArmorType);
    }

    /**
     * Get allowArmorType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAllowArmorType()
    {
        return $this->allowArmorType;
    }
}
