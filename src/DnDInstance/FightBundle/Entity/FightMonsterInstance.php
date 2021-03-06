<?php

namespace DnDInstance\FightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FightMonsterInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\FightBundle\Entity\FightMonsterInstanceRepository")
 */
class FightMonsterInstance
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
     * @ORM\ManyToOne(targetEntity="DnDInstance\FightBundle\Entity\Fight")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fight;

    /**
     * @var integer
     *
     * @ORM\Column(name="initiative", type="integer")
     */
    private $initiative;
    
    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\MonsterBundle\Entity\MonsterInstance")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monsterInstance;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set initiative
     *
     * @param integer $initiative
     * @return FightMonsterInstance
     */
    public function setInitiative($initiative)
    {
        $this->initiative = $initiative;

        return $this;
    }

    /**
     * Get initiative
     *
     * @return integer 
     */
    public function getInitiative()
    {
        return $this->initiative;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return FightMonsterInstance
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
     * @return FightMonsterInstance
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
     * Set monsterInstance
     *
     * @param \DnDInstance\MonsterBundle\Entity\MonsterInstance $monsterInstance
     * @return FightMonsterInstance
     */
    public function setMonsterInstance(\DnDInstance\MonsterBundle\Entity\MonsterInstance $monsterInstance)
    {
        $this->monsterInstance = $monsterInstance;

        return $this;
    }

    /**
     * Get monsterInstance
     *
     * @return \DnDInstance\MonsterBundle\Entity\MonsterInstance 
     */
    public function getMonsterInstance()
    {
        return $this->monsterInstance;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return FightMonsterInstance
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
     * @return FightMonsterInstance
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
     * Constructor
     */
    public function __construct()
    {
        $this->fight = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fight
     *
     * @param \DnDInstance\FightBundle\Entity\Fight $fight
     * @return FightMonsterInstance
     */
    public function setFight(\DnDInstance\FightBundle\Entity\Fight $fight = null)
    {
        $this->fight = $fight;

        return $this;
    }

    /**
     * Get fight
     *
     * @return \DnDInstance\FightBundle\Entity\Fight 
     */
    public function getFight()
    {
        return $this->fight;
    }
}
