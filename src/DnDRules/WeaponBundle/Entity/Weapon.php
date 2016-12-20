<?php

namespace DnDRules\WeaponBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Weapon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\WeaponBundle\Entity\WeaponRepository")
 * 
 * @UniqueEntity(fields="name", message="Une arme semble déjà porter ce nom ...")
 */
class Weapon
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
     * @var string
     * @Assert\Length(
     *      max = "100",
     *      maxMessage = "Votre prix ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="price", type="text", nullable=true)
     */
    private $price;
    
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
     * @ORM\OneToMany(targetEntity="DnDRules\WeaponBundle\Entity\WeaponDamage", mappedBy="weapon", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $damages;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\Critical", mappedBy="weapon", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $criticals;

    /**
     * @var integer
     * Nombre de mains nécessaire pour tenir l'arme
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="handsNumber", type="integer", nullable=true, options={"default" = 1})
     */
    private $handsNumber;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="weaponCategory", type="integer")
     */
    private $weaponCategory;


    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\WeaponType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $weaponType;

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
        $this->damages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criticals = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * Set price
     *
     * @param string $price
     * @return Weapon
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
     * Set scope
     *
     * @param string $scope
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
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
     * Add damages
     *
     * @param \DnDRules\WeaponBundle\Entity\WeaponDamage $damages
     * @return Weapon
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
     * @return Weapon
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
     * @return Weapon
     */
    public function setWeaponType(\DnDRules\WeaponBundle\Entity\WeaponType $weaponType)
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
     * @return Weapon
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
     * @return Weapon
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
