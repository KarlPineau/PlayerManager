<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SpeedSpecialInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\SpeedSpecialInstanceRepository")
 */
class SpeedSpecialInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\SpeedSpecial")
     * @ORM\JoinColumn(nullable=false)
     */
    private $speedSpecial;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="speedSpecialInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $monsterSpeedSpecialInstances;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer", options={"default" = 0})
     */
    private $value;

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
     * Set value
     *
     * @param integer $value
     * @return SpeedSpecialInstance
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return SpeedSpecialInstance
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
     * @return SpeedSpecialInstance
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
     * @return SpeedSpecialInstance
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
     * Set speedSpecial
     *
     * @param \DnDRules\MonsterBundle\Entity\SpeedSpecial $speedSpecial
     * @return SpeedSpecialInstance
     */
    public function setSpeedSpecial(\DnDRules\MonsterBundle\Entity\SpeedSpecial $speedSpecial)
    {
        $this->speedSpecial = $speedSpecial;

        return $this;
    }

    /**
     * Get speedSpecial
     *
     * @return \DnDRules\MonsterBundle\Entity\SpeedSpecial 
     */
    public function getSpeedSpecial()
    {
        return $this->speedSpecial;
    }

    /**
     * Set monsterSpeedSpecialInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterSpeedSpecialInstances
     * @return SpeedSpecialInstance
     */
    public function setMonsterSpeedSpecialInstances(\DnDRules\MonsterBundle\Entity\Monster $monsterSpeedSpecialInstances)
    {
        $this->monsterSpeedSpecialInstances = $monsterSpeedSpecialInstances;

        return $this;
    }

    /**
     * Get monsterSpeedSpecialInstances
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterSpeedSpecialInstances()
    {
        return $this->monsterSpeedSpecialInstances;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return SpeedSpecialInstance
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
     * @return SpeedSpecialInstance
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
