<?php

namespace DnDRules\SortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SortClassDnD
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\SortBundle\Entity\SortClassDnDRepository")
 */
class SortClassDnD
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
     * @ORM\ManyToOne(targetEntity="DnDRules\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
    */
    private $minimumLevel;
    
    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SortBundle\Entity\Sort", inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
    */
    protected $sort;
    
    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnD")
     * @ORM\JoinColumn(nullable=false)
    */
    protected $classdnd;

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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return SortClassDnD
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
     * @return SortClassDnD
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
     * @return SortClassDnD
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
     * Set minimumLevel
     *
     * @param \DnDRules\LevelBundle\Entity\Level $minimumLevel
     * @return SortClassDnD
     */
    public function setMinimumLevel(\DnDRules\LevelBundle\Entity\Level $minimumLevel)
    {
        $this->minimumLevel = $minimumLevel;

        return $this;
    }

    /**
     * Get minimumLevel
     *
     * @return \DnDRules\LevelBundle\Entity\Level 
     */
    public function getMinimumLevel()
    {
        return $this->minimumLevel;
    }

    /**
     * Set sort
     *
     * @param \DnDRules\SortBundle\Entity\Sort $sort
     * @return SortClassDnD
     */
    public function setSort(\DnDRules\SortBundle\Entity\Sort $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return \DnDRules\SortBundle\Entity\Sort 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set classdnd
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnD $classdnd
     * @return SortClassDnD
     */
    public function setClassdnd(\DnDRules\ClassDnDBundle\Entity\ClassDnD $classdnd)
    {
        $this->classdnd = $classdnd;

        return $this;
    }

    /**
     * Get classdnd
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnD 
     */
    public function getClassdnd()
    {
        return $this->classdnd;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return SortClassDnD
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
     * @return SortClassDnD
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
