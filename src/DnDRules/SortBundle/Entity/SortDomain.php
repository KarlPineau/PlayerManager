<?php

namespace DnDRules\SortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SortDomain
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\SortBundle\Entity\SortDomainRepository")
 */
class SortDomain
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
     * @ORM\ManyToOne(targetEntity="DnDRules\SortBundle\Entity\Sort", inversedBy="domains")
     * @ORM\JoinColumn(nullable=false)
    */
    protected $sort;
    
    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SortBundle\Entity\Domain")
     * @ORM\JoinColumn(nullable=false)
    */
    protected $domain;

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
     * @return SortDomain
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
     * @return SortDomain
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
     * @return SortDomain
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
     * @return SortDomain
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
     * @return SortDomain
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
     * Set domain
     *
     * @param \DnDRules\SortBundle\Entity\Domain $domain
     * @return SortDomain
     */
    public function setDomain(\DnDRules\SortBundle\Entity\Domain $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \DnDRules\SortBundle\Entity\Domain 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return SortDomain
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
     * @return SortDomain
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
