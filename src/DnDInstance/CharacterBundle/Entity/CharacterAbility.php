<?php

namespace DnDInstance\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ability
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\CharacterBundle\Entity\CharacterAbilityRepository")
 */
class CharacterAbility
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
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characterUsed;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\AbilityBundle\Entity\Ability")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ability;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="smallint")
     */
    private $value;

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
     * @return ability
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
     * @return ability
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
     * @return ability
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
     * @return ability
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
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return ability
     */
    public function setCharacterUsed(\DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed)
    {
        $this->characterUsed = $characterUsed;

        return $this;
    }

    /**
     * Get characterUsed
     *
     * @return \DnDInstance\CharacterBundle\Entity\CharacterUsed 
     */
    public function getCharacterUsed()
    {
        return $this->characterUsed;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return ability
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
     * @return ability
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
     * Set ability
     *
     * @param \DnDRules\AbilityBundle\Entity\Ability $ability
     * @return CharacterAbility
     */
    public function setAbility(\DnDRules\AbilityBundle\Entity\Ability $ability)
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * Get ability
     *
     * @return \DnDRules\AbilityBundle\Entity\Ability 
     */
    public function getAbility()
    {
        return $this->ability;
    }
}
