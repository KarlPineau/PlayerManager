<?php

namespace DnDInstance\FightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fight
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\FightBundle\Entity\FightRepository")
 */
class Fight
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
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $game;
    
    /**
     * @ORM\ManyToMany(targetEntity="DnDInstance\FightBundle\Entity\FightCharacterUsed", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $fightCharacters;
    
    /**
     * @ORM\ManyToMany(targetEntity="DnDInstance\FightBundle\Entity\FightMonsterInstance", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $fightMonsterInstances;
    
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
        $this->fightCharacters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fightMonsterInstances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Fight
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
     * @return Fight
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
     * @return Fight
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
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return Fight
     */
    public function setGame(\Game\GameBundle\Entity\Game $game)
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

    /**
     * Add fightCharacters
     *
     * @param \DnDInstance\FightBundle\Entity\FightCharacterUsed $fightCharacters
     * @return Fight
     */
    public function addFightCharacter(\DnDInstance\FightBundle\Entity\FightCharacterUsed $fightCharacters)
    {
        $this->fightCharacters[] = $fightCharacters;

        return $this;
    }

    /**
     * Remove fightCharacters
     *
     * @param \DnDInstance\FightBundle\Entity\FightCharacterUsed $fightCharacters
     */
    public function removeFightCharacter(\DnDInstance\FightBundle\Entity\FightCharacterUsed $fightCharacters)
    {
        $this->fightCharacters->removeElement($fightCharacters);
    }

    /**
     * Get fightCharacters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFightCharacters()
    {
        return $this->fightCharacters;
    }

    /**
     * Add fightMonsterInstances
     *
     * @param \DnDInstance\FightBundle\Entity\FightMonsterInstance $fightMonsterInstances
     * @return Fight
     */
    public function addFightMonsterInstance(\DnDInstance\FightBundle\Entity\FightMonsterInstance $fightMonsterInstances)
    {
        $this->fightMonsterInstances[] = $fightMonsterInstances;

        return $this;
    }

    /**
     * Remove fightMonsterInstances
     *
     * @param \DnDInstance\FightBundle\Entity\FightMonsterInstance $fightMonsterInstances
     */
    public function removeFightMonsterInstance(\DnDInstance\FightBundle\Entity\FightMonsterInstance $fightMonsterInstances)
    {
        $this->fightMonsterInstances->removeElement($fightMonsterInstances);
    }

    /**
     * Get fightMonsterInstances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFightMonsterInstances()
    {
        return $this->fightMonsterInstances;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return Fight
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
     * @return Fight
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
