<?php

namespace DnDInstance\ArmorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArmorInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\ArmorBundle\Entity\ArmorInstanceRepository")
 */
class ArmorInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\ArmorBundle\Entity\Armor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $armor;

    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed", inversedBy="armors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characterUsedArmors;

    /**
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game", inversedBy="armorInstances")
     * @ORM\JoinColumn(nullable=true)
     */
    private $game;

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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * Set armor
     *
     * @param \DnDRules\ArmorBundle\Entity\Armor $armor
     * @return ArmorInstance
     */
    public function setArmor(\DnDRules\ArmorBundle\Entity\Armor $armor)
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get armor
     *
     * @return \DnDRules\ArmorBundle\Entity\Armor 
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * @return ArmorInstance
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
     * Set characterUsedArmors
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedArmors
     * @return ArmorInstance
     */
    public function setCharacterUsedArmors(\DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedArmors)
    {
        $this->characterUsedArmors = $characterUsedArmors;

        return $this;
    }

    /**
     * Get characterUsedArmors
     *
     * @return \DnDInstance\CharacterBundle\Entity\CharacterUsed 
     */
    public function getCharacterUsedArmors()
    {
        return $this->characterUsedArmors;
    }

    /**
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return ArmorInstance
     */
    public function setGame(\Game\GameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \Game\GameBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }
}
