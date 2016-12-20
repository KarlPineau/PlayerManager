<?php

namespace DnDRules\WeaponBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WeaponDamage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\WeaponBundle\Entity\WeaponDamageRepository")
 */
class WeaponDamage
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
     * @ORM\ManyToOne(targetEntity="DnDRules\WeaponBundle\Entity\Weapon", inversedBy="damages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $weapon;

    /**
     * @ORM\OneToMany(targetEntity="PM\HomeBundle\Entity\DiceForm", mappedBy="weaponDamage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $damages;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SizeBundle\Entity\Size")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $size;

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
     * Constructor
     */
    public function __construct()
    {
        $this->damages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return WeaponDamage
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
     * @return WeaponDamage
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
     * @return WeaponDamage
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
     * Set weapon
     *
     * @param \DnDRules\WeaponBundle\Entity\Weapon $weapon
     * @return WeaponDamage
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
     * Add damages
     *
     * @param \PM\HomeBundle\Entity\DiceForm $damages
     * @return WeaponDamage
     */
    public function addDamage(\PM\HomeBundle\Entity\DiceForm $damages)
    {
        $this->damages[] = $damages;

        return $this;
    }

    /**
     * Remove damages
     *
     * @param \PM\HomeBundle\Entity\DiceForm $damages
     */
    public function removeDamage(\PM\HomeBundle\Entity\DiceForm $damages)
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
     * Get damages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDamage()
    {
        return $this->damages;
    }

    /**
     * Set size
     *
     * @param \DnDRules\SizeBundle\Entity\Size $size
     * @return WeaponDamage
     */
    public function setSize(\DnDRules\SizeBundle\Entity\Size $size)
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return WeaponDamage
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
     * @return WeaponDamage
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
