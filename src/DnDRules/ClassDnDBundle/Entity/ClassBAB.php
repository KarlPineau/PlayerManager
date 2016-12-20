<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassBAB
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ClassDnDBundle\Entity\ClassBABRepository")
 */
class ClassBAB
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnDLevel", inversedBy="classBABs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $classDnDLevelBABs;

    /**
     * @var integer
     *
     * @ORM\Column(name="attackNb", type="smallint")
     */
    private $attackNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="smallint")
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
     * Set attackNb
     *
     * @param integer $attackNb
     * @return ClassBAB
     */
    public function setAttackNb($attackNb)
    {
        $this->attackNb = $attackNb;

        return $this;
    }

    /**
     * Get attackNb
     *
     * @return integer 
     */
    public function getAttackNb()
    {
        return $this->attackNb;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return ClassBAB
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
     * @return ClassBAB
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
     * @return ClassBAB
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
     * @return ClassBAB
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
     * Set classDnDLevelBABs
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelBABs
     * @return ClassBAB
     */
    public function setClassDnDLevelBABs(\DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelBABs = null)
    {
        $this->classDnDLevelBABs = $classDnDLevelBABs;

        return $this;
    }

    /**
     * Get classDnDLevelBABs
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel 
     */
    public function getClassDnDLevelBABs()
    {
        return $this->classDnDLevelBABs;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassBAB
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
     * @return ClassBAB
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
