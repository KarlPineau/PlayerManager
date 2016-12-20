<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MonsterSkillInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterSkillInstanceRepository")
 */
class MonsterSkillInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="skillInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monsterSkillInstances;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\SkillBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * @var integer
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Votre degré de maitrise doit être supérieur ou égal à 0 ..."
     * )
     *
     * @ORM\Column(name="ranks", type="integer")
     */
    private $ranks;

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
     * Set monster
     *
     * @param \stdClass $monster
     * @return MonsterSkillInstance
     */
    public function setMonster($monster)
    {
        $this->monster = $monster;

        return $this;
    }

    /**
     * Get monster
     *
     * @return \stdClass 
     */
    public function getMonster()
    {
        return $this->monster;
    }

    /**
     * Set skill
     *
     * @param \stdClass $skill
     * @return MonsterSkillInstance
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \stdClass 
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set ranks
     *
     * @param integer $ranks
     * @return MonsterSkillInstance
     */
    public function setRanks($ranks)
    {
        $this->ranks = $ranks;

        return $this;
    }

    /**
     * Get ranks
     *
     * @return integer 
     */
    public function getRanks()
    {
        return $this->ranks;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return MonsterSkillInstance
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
     * @return MonsterSkillInstance
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
     * @return MonsterSkillInstance
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
     * @return MonsterSkillInstance
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
     * @return MonsterSkillInstance
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
     * Set monsterSkillInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterSkillInstances
     * @return MonsterSkillInstance
     */
    public function setMonsterSkillInstances(\DnDRules\MonsterBundle\Entity\Monster $monsterSkillInstances)
    {
        $this->monsterSkillInstances = $monsterSkillInstances;

        return $this;
    }

    /**
     * Get monsterSkillInstances
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterSkillInstances()
    {
        return $this->monsterSkillInstances;
    }
}
