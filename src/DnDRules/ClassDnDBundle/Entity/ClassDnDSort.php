<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassDnDSort
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ClassDnDBundle\Entity\ClassDnDSortRepository")
 */
class ClassDnDSort
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnDLevel", inversedBy="classSorts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $classDnDLevelSorts;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sortLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximumUsedSorts", type="integer")
     */
    private $maximumUsedSorts;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximumKnownSorts", type="integer")
     */
    private $maximumKnownSorts;

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
     * Set maximumUsedSorts
     *
     * @param integer $maximumUsedSorts
     * @return ClassDnDSort
     */
    public function setMaximumUsedSorts($maximumUsedSorts)
    {
        $this->maximumUsedSorts = $maximumUsedSorts;

        return $this;
    }

    /**
     * Get maximumUsedSorts
     *
     * @return integer 
     */
    public function getMaximumUsedSorts()
    {
        return $this->maximumUsedSorts;
    }

    /**
     * Set maximumKnownSorts
     *
     * @param integer $maximumKnownSorts
     * @return ClassDnDSort
     */
    public function setMaximumKnownSorts($maximumKnownSorts)
    {
        $this->maximumKnownSorts = $maximumKnownSorts;

        return $this;
    }

    /**
     * Get maximumKnownSorts
     *
     * @return integer 
     */
    public function getMaximumKnownSorts()
    {
        return $this->maximumKnownSorts;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ClassDnDSort
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
     * @return ClassDnDSort
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
     * @return ClassDnDSort
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
     * Set classDnDLevelSorts
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelSorts
     * @return ClassDnDSort
     */
    public function setClassDnDLevelSorts(\DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelSorts = null)
    {
        $this->classDnDLevelSorts = $classDnDLevelSorts;

        return $this;
    }

    /**
     * Get classDnDLevelSorts
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel 
     */
    public function getClassDnDLevelSorts()
    {
        return $this->classDnDLevelSorts;
    }

    /**
     * Set sortLevel
     *
     * @param \DnDRules\LevelBundle\Entity\Level $sortLevel
     * @return ClassDnDSort
     */
    public function setSortLevel(\DnDRules\LevelBundle\Entity\Level $sortLevel)
    {
        $this->sortLevel = $sortLevel;

        return $this;
    }

    /**
     * Get sortLevel
     *
     * @return \DnDRules\LevelBundle\Entity\Level 
     */
    public function getSortLevel()
    {
        return $this->sortLevel;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassDnDSort
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
     * @return ClassDnDSort
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
