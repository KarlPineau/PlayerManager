<?php

namespace DnDInstance\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassDnDInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\ClassDnDBundle\Entity\ClassDnDInstanceRepository")
 */
class ClassDnDInstance
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
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed", inversedBy="classDnDInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characterUsedDnDInstance;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnD")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classDnD;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ClassDnDInstance
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
     * @return ClassDnDInstance
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
     * Set characterUsedDnDInstance
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedDnDInstance
     * @return ClassDnDInstance
     */
    public function setCharacterUsedDnDInstance(\DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedDnDInstance = null)
    {
        $this->characterUsedDnDInstance = $characterUsedDnDInstance;

        return $this;
    }

    /**
     * Get characterUsedDnDInstance
     *
     * @return \DnDInstance\CharacterBundle\Entity\CharacterUsed 
     */
    public function getCharacterUsedDnDInstance()
    {
        return $this->characterUsedDnDInstance;
    }

    /**
     * Set classDnD
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnD $classDnD
     * @return ClassDnDInstance
     */
    public function setClassDnD(\DnDRules\ClassDnDBundle\Entity\ClassDnD $classDnD)
    {
        $this->classDnD = $classDnD;

        return $this;
    }

    /**
     * Get classDnD
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnD 
     */
    public function getClassDnD()
    {
        return $this->classDnD;
    }

    /**
     * Set level
     *
     * @param \DnDRules\LevelBundle\Entity\Level $level
     * @return ClassDnDInstance
     */
    public function setLevel(\DnDRules\LevelBundle\Entity\Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \DnDRules\LevelBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassDnDInstance
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
     * @return ClassDnDInstance
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
