<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Monster
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterRepository")
 * 
 * @UniqueEntity(fields="name", message="Un monstre semble déjà porter ce nom ...")
 */
class Monster
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
     *      max = "10000",
     *      maxMessage = "Votre description ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\DiceForm", mappedBy="monsterHpForm", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $hpForm;

    /**
     * @var integer
     *
     * @ORM\Column(name="hpAverage", type="smallint", options={"default" = 0}, nullable=true)
     */
    private $hpAverage;

    /**
     * @var integer
     *
     * @ORM\Column(name="bab", type="smallint", nullable=true, options={"default" = 0})
     */
    private $bab;

    /**
     * @var integer
     *
     * @ORM\Column(name="bfb", type="smallint", nullable=true, options={"default" = 0})
     */
    private $bfb;

    /**
     * @var integer
     *
     * @ORM\Column(name="ac", type="smallint", nullable=true, options={"default" = 0})
     */
    private $ac;

    /**
     * @var integer
     *
     * @ORM\Column(name="ffAC", type="smallint", nullable=true, options={"default" = 0})
     */
    private $ffAC;

    /**
     * @var integer
     *
     * @ORM\Column(name="touchAC", type="smallint", nullable=true, options={"default" = 0})
     */
    private $touchAC;

    /**
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre monstre ne peut pas avoir une vitesse négative ou nulle."
     * )
     *
     * @ORM\Column(name="speed", type="float", nullable=true)
     */
    private $speed;

    /**
     * @Assert\Range(
     *      min = "0",
     *      minMessage = "Votre monstre ne peut pas avoir une taille d'espace occupé négative."
     * )
     *
     * @ORM\Column(name="spaceOccupied", type="float", nullable=true)
     */
    private $spaceOccupied;

    /**
     * @Assert\Range(
     *      min = "0",
     *      minMessage = "Votre monstre ne peut pas avoir un espace d'influence négatif."
     * )
     *
     * @ORM\Column(name="areaLying", type="float", nullable=true)
     */
    private $areaLying;

    /**
     * @var integer
     *
     * @ORM\Column(name="initiative", type="smallint", nullable=true, options={"default" = 0})
     */
    private $initiative;

    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre Organisation Sociale ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="socialOrganisation", type="text", nullable=true)
     */
    private $socialOrganisation;

    /**
     * @var integer
     *
     * @ORM\Column(name="powerfullFactor", type="smallint", nullable=true, options={"default" = 0})
     */
    private $powerfullFactor;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\GiftBundle\Entity\Gift")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gifts;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\LanguageBundle\Entity\Language")
     * @ORM\JoinColumn(nullable=true)
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity="DnDRules\AlignmentBundle\Entity\Alignment")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $alignments;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Environment")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $environment;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\MonsterBundle\Entity\SpeedSpecialInstance", mappedBy="monsterSpeedSpecialInstances", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $speedSpecialInstances;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\MonsterBundle\Entity\MonsterSkillInstance", mappedBy="monsterSkillInstances", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $skillInstances;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\MonsterBundle\Entity\MonsterAbilityInstance", mappedBy="monsterAbilityInstances", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $abilityInstances;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance", mappedBy="monsterAttackExtremeInstances", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $attackExtremeInstances;

    /**
     * @var string
     * @Assert\Length(
     *      max = "5000",
     *      maxMessage = "Votre description ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="attackExtremeDescription", type="text", nullable=true)
     */
    private $attackExtremeDescription;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\MonsterBundle\Entity\MonsterAttackInstance", mappedBy="monsterAttackInstances", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $attackInstances;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hpForm = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gifts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->speedSpecialInstances = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skillInstances = new \Doctrine\Common\Collections\ArrayCollection();
        $this->abilityInstances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Monster
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
     * @return Monster
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
     * @return Monster
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
     * Set hpAverage
     *
     * @param integer $hpAverage
     * @return Monster
     */
    public function setHpAverage($hpAverage)
    {
        $this->hpAverage = $hpAverage;

        return $this;
    }

    /**
     * Get hpAverage
     *
     * @return integer 
     */
    public function getHpAverage()
    {
        return $this->hpAverage;
    }

    /**
     * Set bab
     *
     * @param integer $bab
     * @return Monster
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
     * Set ac
     *
     * @param integer $ac
     * @return Monster
     */
    public function setAc($ac)
    {
        $this->ac = $ac;

        return $this;
    }

    /**
     * Get ac
     *
     * @return integer 
     */
    public function getAc()
    {
        return $this->ac;
    }

    /**
     * Set ffAC
     *
     * @param integer $ffAC
     * @return Monster
     */
    public function setFfAC($ffAC)
    {
        $this->ffAC = $ffAC;

        return $this;
    }

    /**
     * Get ffAC
     *
     * @return integer 
     */
    public function getFfAC()
    {
        return $this->ffAC;
    }

    /**
     * Set touchAC
     *
     * @param integer $touchAC
     * @return Monster
     */
    public function setTouchAC($touchAC)
    {
        $this->touchAC = $touchAC;

        return $this;
    }

    /**
     * Get touchAC
     *
     * @return integer 
     */
    public function getTouchAC()
    {
        return $this->touchAC;
    }

    /**
     * Set speed
     *
     * @param float $speed
     * @return Monster
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return float 
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set spaceOccupied
     *
     * @param float $spaceOccupied
     * @return Monster
     */
    public function setSpaceOccupied($spaceOccupied)
    {
        $this->spaceOccupied = $spaceOccupied;

        return $this;
    }

    /**
     * Get spaceOccupied
     *
     * @return float 
     */
    public function getSpaceOccupied()
    {
        return $this->spaceOccupied;
    }

    /**
     * Set areaLying
     *
     * @param float $areaLying
     * @return Monster
     */
    public function setAreaLying($areaLying)
    {
        $this->areaLying = $areaLying;

        return $this;
    }

    /**
     * Get areaLying
     *
     * @return float 
     */
    public function getAreaLying()
    {
        return $this->areaLying;
    }

    /**
     * Set initiative
     *
     * @param integer $initiative
     * @return Monster
     */
    public function setInitiative($initiative)
    {
        $this->initiative = $initiative;

        return $this;
    }

    /**
     * Get initiative
     *
     * @return integer 
     */
    public function getInitiative()
    {
        return $this->initiative;
    }

    /**
     * Set socialOrganisation
     *
     * @param string $socialOrganisation
     * @return Monster
     */
    public function setSocialOrganisation($socialOrganisation)
    {
        $this->socialOrganisation = $socialOrganisation;

        return $this;
    }

    /**
     * Get socialOrganisation
     *
     * @return string 
     */
    public function getSocialOrganisation()
    {
        return $this->socialOrganisation;
    }

    /**
     * Set powerfullFactor
     *
     * @param integer $powerfullFactor
     * @return Monster
     */
    public function setPowerfullFactor($powerfullFactor)
    {
        $this->powerfullFactor = $powerfullFactor;

        return $this;
    }

    /**
     * Get powerfullFactor
     *
     * @return integer 
     */
    public function getPowerfullFactor()
    {
        return $this->powerfullFactor;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Monster
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
     * @return Monster
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
     * Add hpForm
     *
     * @param \PM\HomeBundle\Entity\DiceForm $hpForm
     * @return Monster
     */
    public function addHpForm(\PM\HomeBundle\Entity\DiceForm $hpForm)
    {
        $this->hpForm[] = $hpForm;

        return $this;
    }

    /**
     * Remove hpForm
     *
     * @param \PM\HomeBundle\Entity\DiceForm $hpForm
     */
    public function removeHpForm(\PM\HomeBundle\Entity\DiceForm $hpForm)
    {
        $this->hpForm->removeElement($hpForm);
    }

    /**
     * Get hpForm
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHpForm()
    {
        return $this->hpForm;
    }

    /**
     * Add gifts
     *
     * @param \DnDRules\GiftBundle\Entity\Gift $gifts
     * @return Monster
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
     * Add languages
     *
     * @param \DnDRules\LanguageBundle\Entity\Language $languages
     * @return Monster
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
     * Set environment
     *
     * @param \DnDRules\MonsterBundle\Entity\Environment $environment
     * @return Monster
     */
    public function setEnvironment(\DnDRules\MonsterBundle\Entity\Environment $environment = null)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return \DnDRules\MonsterBundle\Entity\Environment 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Add speedSpecialInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\SpeedSpecialInstance $speedSpecialInstances
     * @return Monster
     */
    public function addSpeedSpecialInstance(\DnDRules\MonsterBundle\Entity\SpeedSpecialInstance $speedSpecialInstances)
    {
        $this->speedSpecialInstances[] = $speedSpecialInstances;

        return $this;
    }

    /**
     * Remove speedSpecialInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\SpeedSpecialInstance $speedSpecialInstances
     */
    public function removeSpeedSpecialInstance(\DnDRules\MonsterBundle\Entity\SpeedSpecialInstance $speedSpecialInstances)
    {
        $this->speedSpecialInstances->removeElement($speedSpecialInstances);
    }

    /**
     * Get speedSpecialInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpeedSpecialInstances()
    {
        return $this->speedSpecialInstances;
    }

    /**
     * Add skillInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterSkillInstance $skillInstances
     * @return Monster
     */
    public function addSkillInstance(\DnDRules\MonsterBundle\Entity\MonsterSkillInstance $skillInstances)
    {
        $this->skillInstances[] = $skillInstances;

        return $this;
    }

    /**
     * Remove skillInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterSkillInstance $skillInstances
     */
    public function removeSkillInstance(\DnDRules\MonsterBundle\Entity\MonsterSkillInstance $skillInstances)
    {
        $this->skillInstances->removeElement($skillInstances);
    }

    /**
     * Get skillInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkillInstances()
    {
        return $this->skillInstances;
    }

    /**
     * Add abilityInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAbilityInstance $abilityInstances
     * @return Monster
     */
    public function addAbilityInstance(\DnDRules\MonsterBundle\Entity\MonsterAbilityInstance $abilityInstances)
    {
        $this->abilityInstances[] = $abilityInstances;

        return $this;
    }

    /**
     * Remove abilityInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAbilityInstance $abilityInstances
     */
    public function removeAbilityInstance(\DnDRules\MonsterBundle\Entity\MonsterAbilityInstance $abilityInstances)
    {
        $this->abilityInstances->removeElement($abilityInstances);
    }

    /**
     * Get abilityInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbilityInstances()
    {
        return $this->abilityInstances;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return Monster
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
     * @return Monster
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
     * Add attackInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attackInstances
     * @return Monster
     */
    public function addAttackInstance(\DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attackInstances)
    {
        $this->attackInstances[] = $attackInstances;

        return $this;
    }

    /**
     * Remove attackInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attackInstances
     */
    public function removeAttackInstance(\DnDRules\MonsterBundle\Entity\MonsterAttackInstance $attackInstances)
    {
        $this->attackInstances->removeElement($attackInstances);
    }

    /**
     * Get attackInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttackInstances()
    {
        return $this->attackInstances;
    }

    /**
     * Set bfb
     *
     * @param integer $bfb
     * @return Monster
     */
    public function setBfb($bfb)
    {
        $this->bfb = $bfb;

        return $this;
    }

    /**
     * Get bfb
     *
     * @return integer 
     */
    public function getBfb()
    {
        return $this->bfb;
    }

    /**
     * Add alignments
     *
     * @param \DnDRules\AlignmentBundle\Entity\Alignment $alignments
     * @return Monster
     */
    public function addAlignment(\DnDRules\AlignmentBundle\Entity\Alignment $alignments)
    {
        $this->alignments[] = $alignments;

        return $this;
    }

    /**
     * Remove alignments
     *
     * @param \DnDRules\AlignmentBundle\Entity\Alignment $alignments
     */
    public function removeAlignment(\DnDRules\AlignmentBundle\Entity\Alignment $alignments)
    {
        $this->alignments->removeElement($alignments);
    }

    /**
     * Get alignments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlignments()
    {
        return $this->alignments;
    }

    /**
     * Add attackExtremeInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance $attackExtremeInstances
     * @return Monster
     */
    public function addAttackExtremeInstance(\DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance $attackExtremeInstances)
    {
        $this->attackExtremeInstances[] = $attackExtremeInstances;

        return $this;
    }

    /**
     * Remove attackExtremeInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance $attackExtremeInstances
     */
    public function removeAttackExtremeInstance(\DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance $attackExtremeInstances)
    {
        $this->attackExtremeInstances->removeElement($attackExtremeInstances);
    }

    /**
     * Get attackExtremeInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttackExtremeInstances()
    {
        return $this->attackExtremeInstances;
    }

    /**
     * Set attackExtremeDescription
     *
     * @param string $attackExtremeDescription
     * @return Monster
     */
    public function setAttackExtremeDescription($attackExtremeDescription)
    {
        $this->attackExtremeDescription = $attackExtremeDescription;

        return $this;
    }

    /**
     * Get attackExtremeDescription
     *
     * @return string 
     */
    public function getAttackExtremeDescription()
    {
        return $this->attackExtremeDescription;
    }
}
