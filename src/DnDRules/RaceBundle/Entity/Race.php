<?php

namespace DnDRules\RaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Race
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\RaceBundle\Entity\RaceRepository")
 * 
 * @UniqueEntity(fields="name", message="Une race semble déjà porter ce nom ...")
 */
class Race
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
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre description ne doit pas dépasser {{ limit }} caractères."
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SizeBundle\Entity\Size")
     * @ORM\JoinColumn(nullable=false)
     */
    private $size;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre race ne peut pas avoir une vitesse négative ou nulle."
     * )
     *
     * @ORM\Column(name="speed", type="float")
     */
    private $speed;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre race ne peut pas avoir un modificateur de Points de Compétences négatif ou nul."
     * )
     *
     * @ORM\Column(name="skillModifier", type="smallint")
     */
    private $skillModifier;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnD")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $predilectionClass;
    
    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\LanguageBundle\Entity\Language")
     * @ORM\JoinColumn(nullable=true)
     */
    private $languages;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "0",
     *      minMessage = "Votre race ne peut pas avoir un modificateur du nombre de PV négatif."
     * )
     *
     * @ORM\Column(name="hpMdifier", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $hpModifier;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\RaceBundle\Entity\RaceAbility", mappedBy="race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abilities;

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
     * Constructor
     */
    public function __construct()
    {
        $this->predilectionClass = New ArrayCollection();
        $this->languages = New ArrayCollection();
        $this->abilities = New ArrayCollection();
    }


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
     * @return Race
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
     * @return Race
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
     * Set slug
     *
     * @param string $slug
     * @return Race
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
     * Set size
     *
     * @param \DnDRules\SizeBundle\Entity\Size $size
     * @return Race
     */
    public function setSize(\DnDRules\SizeBundle\Entity\Size $size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return \DnDRules\SizeBundle\Entity\Size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set skillModifier
     *
     * @param integer $skillModifier
     * @return Race
     */
    public function setSkillModifier($skillModifier)
    {
        $this->skillModifier = $skillModifier;

        return $this;
    }

    /**
     * Get skillModifier
     *
     * @return integer 
     */
    public function getSkillModifier()
    {
        return $this->skillModifier;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Race
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
     * @return Race
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
     * @return Race
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
     * Set predilectionClass
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnD $predilectionClass
     * @return Race
     */
    public function setPredilectionClass(\DnDRules\ClassDnDBundle\Entity\ClassDnD $predilectionClass = null)
    {
        $this->predilectionClass = $predilectionClass;

        return $this;
    }

    /**
     * Get predilectionClass
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnD 
     */
    public function getPredilectionClass()
    {
        return $this->predilectionClass;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return Race
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
     * @return Race
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
     * Set speed
     *
     * @param string $speed
     * @return Race
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return string 
     */
    public function getSpeed()
    {
        return $this->speed;
    }
    
    /**
     * Add languages
     *
     * @param \DnDRules\LanguageBundle\Entity\Language $language
     * @return Race
     */
    public function addLanguage(\DnDRules\LanguageBundle\Entity\Language $language)
    {
        $this->languages[] = $language;
        $language->setRace($this);

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \DnDRules\LanguageBundle\Entity\Language $language
     */
    public function removeLanguage(\DnDRules\LanguageBundle\Entity\Language $language)
    {
        $this->languages->removeElement($language);
        
        $language->setRace(null);
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
     * Set hpModifier
     *
     * @param integer $hpModifier
     * @return Race
     */
    public function setHpModifier($hpModifier)
    {
        $this->hpModifier = $hpModifier;

        return $this;
    }

    /**
     * Get hpModifier
     *
     * @return integer 
     */
    public function getHpModifier()
    {
        return $this->hpModifier;
    }

    /**
     * Add abilities
     *
     * @param \DnDRules\RaceBundle\Entity\RaceAbility $ability
     * @return Race
     */
    public function addAbility(\DnDRules\RaceBundle\Entity\RaceAbility $ability)
    {
        $this->abilities[] = $ability;
        $ability->setRace($this);

        return $this;
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
     * Remove ability
     *
     * @param \DnDRules\RaceBundle\Entity\RaceAbility $ability
     */
    public function removeClassDnDInstance(\DnDRules\RaceBundle\Entity\RaceAbility $ability)
    {
        $this->abilities->removeElement($ability);
    }
}
