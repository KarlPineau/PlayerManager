<?php

namespace DnDRules\AbilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Ability
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\AbilityBundle\Entity\AbilityRepository")
 * 
 * @UniqueEntity(fields="name", message="Une Caractéristique semble déjà porter ce nom ...")
 */
class Ability
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "1",
     *      max = "6",
     *      minMessage = "Le type de la caractéristique doit être compris entre 1 et 6.",
     *      maxMessage = "Le type de la caractéristique doit être compris entre 1 et 6."
     * )
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

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
     * Set name
     *
     * @param string $name
     * @return Ability
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
     * Set description
     *
     * @param string $description
     * @return Ability
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Ability
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
     * @return Ability
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
     * @return Ability
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return Ability
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
     * @return Ability
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Ability
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
     * Set type
     *
     * @param integer $type
     * @return Ability
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
}
