<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassST 
 * -> Matérialisation des jets de sauvergarde
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\ClassDnDBundle\Entity\ClassSTRepository")
 */
class ClassST
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassDnDLevel", inversedBy="classST")
     * @ORM\JoinColumn(nullable=true)
     */
    private $classDnDLevelST;

    /**
     * @var integer
     *
     * @ORM\Column(name="fortitude", type="smallint")
     */
    private $fortitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="reflex", type="smallint")
     */
    private $reflex;

    /**
     * @var integer
     *
     * @ORM\Column(name="will", type="smallint")
     */
    private $will;

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
     * Set fortitude
     *
     * @param integer $fortitude
     * @return ClassST
     */
    public function setFortitude($fortitude)
    {
        $this->fortitude = $fortitude;

        return $this;
    }

    /**
     * Get fortitude
     *
     * @return integer 
     */
    public function getFortitude()
    {
        return $this->fortitude;
    }

    /**
     * Set reflex
     *
     * @param integer $reflex
     * @return ClassST
     */
    public function setReflex($reflex)
    {
        $this->reflex = $reflex;

        return $this;
    }

    /**
     * Get reflex
     *
     * @return integer 
     */
    public function getReflex()
    {
        return $this->reflex;
    }

    /**
     * Set will
     *
     * @param integer $will
     * @return ClassST
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return integer 
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ClassST
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
     * @return ClassST
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
     * @return ClassST
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
     * Set classDnDLevelST
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelST
     * @return ClassST
     */
    public function setClassDnDLevelST(\DnDRules\ClassDnDBundle\Entity\ClassDnDLevel $classDnDLevelST = null)
    {
        $this->classDnDLevelST = $classDnDLevelST;

        return $this;
    }

    /**
     * Get classDnDLevelST
     *
     * @return \DnDRules\ClassDnDBundle\Entity\ClassDnDLevel 
     */
    public function getClassDnDLevelST()
    {
        return $this->classDnDLevelST;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ClassST
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
     * @return ClassST
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
