<?php

namespace DnDInstance\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharacterUsed
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\CharacterBundle\Entity\CharacterUsedRepository")
 */
class CharacterUsed
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
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game", inversedBy="characters")
     * @ORM\JoinColumn(nullable=true)
     */
    private $game;

    /**
     * @var string
     * @Assert\Length(
     *      min = "1",
     *      max = "45",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Votre nom ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name", "createDate"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     */
    private $slug;
    
    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre histoire ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="story", type="text", nullable=true)
     */
    private $story;

    /**
     * @var integer
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre personnage ne peut pas avoir un âge négatif ou nul."
     * )
     * 
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     * @Assert\Choice(choices = {"Homme", "Femme"}, message = "Choisissez un genre valide.")
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @var integer
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre personnage ne peut pas avoir une taille négative ou nulle."
     * )
     *
     * @ORM\Column(name="height", type="smallint", nullable=true)
     */
    private $height;

    /**
     * @var integer
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre personnage ne peut pas avoir un poids négatif ou nul."
     * )
     *
     * @ORM\Column(name="weight", type="smallint", nullable=true)
     */
    private $weight;

    /**
     * @var integer
     * @Assert\Range(
     *      min = "0",
     *      minMessage = "Votre personnage ne peut pas avoir un nombre de PV maximum négatif."
     * )
     *
     * @ORM\Column(name="hpMax", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $hpMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="hpCurrent", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $hpCurrent;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\AlignmentBundle\Entity\Alignment")
     * @ORM\JoinColumn(nullable=true)
     */
    private $alignment;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\GiftBundle\Entity\Gift")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gifts;

    /**
     * @ORM\OneToMany(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterAbility", mappedBy="characterUsedDnDAbilities", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $abilities;

    /**
     * @ORM\OneToMany(targetEntity="DnDInstance\CharacterBundle\Entity\XpPoints", mappedBy="characterUsedDnDXpPoints", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $xpPoints;

    /**
     * @ORM\OneToMany(targetEntity="DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance", mappedBy="characterUsedDnDInstance", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $classDnDInstances;

    /**
     * @ORM\OneToMany(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterSkill", mappedBy="characterUsedSkills", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\LanguageBundle\Entity\Language")
     * @ORM\JoinColumn(nullable=true)
     */
    private $languages;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\RaceBundle\Entity\Race")
     * @ORM\JoinColumn(nullable=true)
     */
    private $race;

    /**
     * @ORM\OneToMany(targetEntity="DnDInstance\EquipmentBundle\Entity\EquipmentInstance", mappedBy="characterUsedEquipments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $equipments;

    /**
     * @ORM\ManyToOne(targetEntity="CAS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
        $this->gifts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classDnDInstances = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CharacterUsed
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
     * @return CharacterUsed
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
     * Set story
     *
     * @param string $story
     * @return CharacterUsed
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string 
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return CharacterUsed
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return CharacterUsed
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return CharacterUsed
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return CharacterUsed
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set hpMax
     *
     * @param integer $hpMax
     * @return CharacterUsed
     */
    public function setHpMax($hpMax)
    {
        $this->hpMax = $hpMax;

        return $this;
    }

    /**
     * Get hpMax
     *
     * @return integer 
     */
    public function getHpMax()
    {
        return $this->hpMax;
    }

    /**
     * Set hpCurrent
     *
     * @param integer $hpCurrent
     * @return CharacterUsed
     */
    public function setHpCurrent($hpCurrent)
    {
        $this->hpCurrent = $hpCurrent;

        return $this;
    }

    /**
     * Get hpCurrent
     *
     * @return integer 
     */
    public function getHpCurrent()
    {
        return $this->hpCurrent;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return CharacterUsed
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
     * @return CharacterUsed
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
     * Set alignment
     *
     * @param \DnDRules\AlignmentBundle\Entity\Alignment $alignment
     * @return CharacterUsed
     */
    public function setAlignment(\DnDRules\AlignmentBundle\Entity\Alignment $alignment = null)
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Get alignment
     *
     * @return \DnDRules\AlignmentBundle\Entity\Alignment 
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * Add gifts
     *
     * @param \DnDRules\GiftBundle\Entity\Gift $gifts
     * @return CharacterUsed
     */
    public function addGift(\DnDRules\GiftBundle\Entity\Gift $gifts)
    {
        $this->gifts[] = $gifts;

        return $this;
    }

    /**
     * Remove gifts
     *
     * @param \DnDRules\GiftBundle\Entity\Gift $gifts
     */
    public function removeGift(\DnDRules\GiftBundle\Entity\Gift $gifts)
    {
        $this->gifts->removeElement($gifts);
    }

    /**
     * Get gifts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGifts()
    {
        return $this->gifts;
    }

    /**
     * Add classDnDInstances
     *
     * @param \DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance $classDnDInstances
     * @return CharacterUsed
     */
    public function addClassDnDInstance(\DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance $classDnDInstances)
    {
        $this->classDnDInstances[] = $classDnDInstances;

        return $this;
    }

    /**
     * Remove classDnDInstances
     *
     * @param \DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance $classDnDInstances
     */
    public function removeClassDnDInstance(\DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance $classDnDInstances)
    {
        $this->classDnDInstances->removeElement($classDnDInstances);
    }

    /**
     * Get classDnDInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassDnDInstances()
    {
        return $this->classDnDInstances;
    }

    /**
     * Add skills
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterSkill $skills
     * @return CharacterUsed
     */
    public function addSkill(\DnDInstance\CharacterBundle\Entity\CharacterSkill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterSkill $skills
     */
    public function removeSkill(\DnDInstance\CharacterBundle\Entity\CharacterSkill $skills)
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
     * Add languages
     *
     * @param \DnDRules\LanguageBundle\Entity\Language $languages
     * @return CharacterUsed
     */
    public function addLanguage(\DnDRules\LanguageBundle\Entity\Language $languages)
    {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \DnDRules\LanguageBundle\Entity\Language $languages
     */
    public function removeLanguage(\DnDRules\LanguageBundle\Entity\Language $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set race
     *
     * @param \DnDRules\RaceBundle\Entity\Race $race
     * @return CharacterUsed
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
     * Add equipments
     *
     * @param \DnDInstance\EquipmentBundle\Entity\EquipmentInstance $equipments
     * @return CharacterUsed
     */
    public function addEquipment(\DnDInstance\EquipmentBundle\Entity\EquipmentInstance $equipments)
    {
        $this->equipments[] = $equipments;

        return $this;
    }

    /**
     * Remove equipments
     *
     * @param \DnDInstance\EquipmentBundle\Entity\EquipmentInstance $equipments
     */
    public function removeEquipment(\DnDInstance\EquipmentBundle\Entity\EquipmentInstance $equipments)
    {
        $this->equipments->removeElement($equipments);
    }

    /**
     * Get equipments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipments()
    {
        return $this->equipments;
    }

    /**
     * Set user
     *
     * @param \CAS\UserBundle\Entity\User $user
     * @return CharacterUsed
     */
    public function setUser(\CAS\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CAS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return CharacterUsed
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
     * @return CharacterUsed
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
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return CharacterUsed
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
     * Add abilities
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterAbility $abilities
     * @return CharacterUsed
     */
    public function addAbility(\DnDInstance\CharacterBundle\Entity\CharacterAbility $abilities)
    {
        $this->abilities[] = $abilities;

        return $this;
    }

    /**
     * Remove abilities
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterAbility $abilities
     */
    public function removeAbility(\DnDInstance\CharacterBundle\Entity\CharacterAbility $abilities)
    {
        $this->abilities->removeElement($abilities);
    }

    /**
     * Get abilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * Add xpPoints
     *
     * @param \DnDInstance\CharacterBundle\Entity\XpPoints $xpPoints
     * @return CharacterUsed
     */
    public function addXpPoint(\DnDInstance\CharacterBundle\Entity\XpPoints $xpPoints)
    {
        $this->xpPoints[] = $xpPoints;

        return $this;
    }

    /**
     * Remove xpPoints
     *
     * @param \DnDInstance\CharacterBundle\Entity\XpPoints $xpPoints
     */
    public function removeXpPoint(\DnDInstance\CharacterBundle\Entity\XpPoints $xpPoints)
    {
        $this->xpPoints->removeElement($xpPoints);
    }

    /**
     * Get xpPoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getXpPoints()
    {
        return $this->xpPoints;
    }
}
