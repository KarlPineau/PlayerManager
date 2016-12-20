<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassDnDLevel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ClassDnDBundle\Entity\ClassDnDLevelRepository")
 */
class ClassDnDLevel
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnD", inversedBy="levels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classDnD;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassST", mappedBy="classDnDLevelST", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $classST;
    
    /**
     * @ORM\OneToMany(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassBAB", mappedBy="classDnDLevelBABs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $classBABs;
    
    /**
     * @ORM\OneToMany(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnDSort", mappedBy="classDnDLevelSorts", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $classSorts;

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
        $this->classST = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classBABs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classSorts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ClassDnDLevel
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
     * @return ClassDnDLevel
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
     * @return ClassDnDLevel
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
     * Set classDnD
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnD $classDnD
     * @return ClassDnDLevel
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
     * @return ClassDnDLevel
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
     * Add classST
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassST $classST
     * @return ClassDnDLevel
     */
    public function addClassST(\DnDRules\ClassDnDBundle\Entity\ClassST $classST)
    {
        $this->classST[] = $classST;

        return $this;
    }

    /**
     * Remove classST
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassST $classST
     */
    public function removeClassST(\DnDRules\ClassDnDBundle\Entity\ClassST $classST)
    {
        $this->classST->removeElement($classST);
    }

    /**
     * Get classST
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassST()
    {
        return $this->classST;
    }

    /**
     * Add classBABs
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassBAB $classBABs
     * @return ClassDnDLevel
     */
    public function addClassBAB(\DnDRules\ClassDnDBundle\Entity\ClassBAB $classBABs)
    {
        $this->classBABs[] = $classBABs;

        return $this;
    }

    /**
     * Remove classBABs
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassBAB $classBABs
     */
    public function removeClassBAB(\DnDRules\ClassDnDBundle\Entity\ClassBAB $classBABs)
    {
        $this->classBABs->removeElement($classBABs);
    }

    /**
     * Get classBABs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassBABs()
    {
        return $this->classBABs;
    }

    /**
     * Add classSorts
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDSort $classSorts
     * @return ClassDnDLevel
     */
    public function addClassSort(\DnDRules\ClassDnDBundle\Entity\ClassDnDSort $classSorts)
    {
        $this->classSorts[] = $classSorts;

        return $this;
    }

    /**
     * Remove classSorts
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDSort $classSorts
     */
    public function removeClassSort(\DnDRules\ClassDnDBundle\Entity\ClassDnDSort $classSorts)
    {
        $this->classSorts->removeElement($classSorts);
    }

    /**
     * Get classSorts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassSorts()
    {
        return $this->classSorts;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassDnDLevel
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
     * @return ClassDnDLevel
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
