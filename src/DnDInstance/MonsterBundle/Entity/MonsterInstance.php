<?php

namespace DnDInstance\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * MonsterInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\MonsterBundle\Entity\MonsterInstanceRepository")
 */
class MonsterInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $monster;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name", "name"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $game;

    /**
     * @var string
     * @Assert\Length(
     *      max = "45",
     *      maxMessage = "Votre champ 'Nom' ne doit pas mesurer plus de {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;
    
    /**
     * @var string
     * @Assert\Length(
     *      max = "10000",
     *      maxMessage = "Votre histoire ne doit pas dépasser {{ limit }} caractères."
     * )
     *
     * @ORM\Column(name="story", type="text", nullable=true)
     */
    private $story;

    /**
     * @var integer
     * @Assert\Range(
     *      min = "1",
     *      minMessage = "Votre personnage ne peut pas avoir un âge négatif ou nul."
     * )
     * 
     * @ORM\Column(name="age", type="smallint", nullable=true)
     */
    private $age;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "0",
     *      minMessage = "Votre personnage ne peut pas avoir un nombre de PV maximum négatif."
     * )
     *
     * @ORM\Column(name="hpMax", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $hpMax;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="hpCurrent", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $hpCurrent;

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
     * Set slug
     *
     * @param string $slug
     * @return MonsterInstance
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
     * Set name
     *
     * @param string $name
     * @return MonsterInstance
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
     * Set story
     *
     * @param string $story
     * @return MonsterInstance
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string 
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return MonsterInstance
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set hpMax
     *
     * @param integer $hpMax
     * @return MonsterInstance
     */
    public function setHpMax($hpMax)
    {
        $this->hpMax = $hpMax;

        return $this;
    }

    /**
     * Get hpMax
     *
     * @return integer 
     */
    public function getHpMax()
    {
        return $this->hpMax;
    }

    /**
     * Set hpCurrent
     *
     * @param integer $hpCurrent
     * @return MonsterInstance
     */
    public function setHpCurrent($hpCurrent)
    {
        $this->hpCurrent = $hpCurrent;

        return $this;
    }

    /**
     * Get hpCurrent
     *
     * @return integer 
     */
    public function getHpCurrent()
    {
        return $this->hpCurrent;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return MonsterInstance
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
     * @return MonsterInstance
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
     * Set monster
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monster
     * @return MonsterInstance
     */
    public function setMonster(\DnDRules\MonsterBundle\Entity\Monster $monster)
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * Get monster
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonster()
    {
        return $this->monster;
    }

    /**
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return MonsterInstance
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return MonsterInstance
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
     * @return MonsterInstance
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
