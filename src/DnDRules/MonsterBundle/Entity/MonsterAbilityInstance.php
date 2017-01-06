<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MonsterAbilityInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterAbilityInstanceRepository")
 */
class MonsterAbilityInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\MonsterBundle\Entity\Monster", inversedBy="abilityInstances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monsterAbilityInstances;

    /**
     * @ORM\ManyToOne(targetEntity="DnDRules\AbilityBundle\Entity\Ability")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ability;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

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
     * Set value
     *
     * @param integer $value
     * @return MonsterAbilityInstance
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
     * @return MonsterAbilityInstance
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
     * @return MonsterAbilityInstance
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
     * Set monsterAbilityInstances
     *
     * @param \DnDRules\MonsterBundle\Entity\Monster $monsterAbilityInstances
     * @return MonsterAbilityInstance
     */
    public function setMonsterAbilityInstances(\DnDRules\MonsterBundle\Entity\Monster $monsterAbilityInstances)
    {
        $this->monsterAbilityInstances = $monsterAbilityInstances;

        return $this;
    }

    /**
     * Get monsterAbilityInstances
     *
     * @return \DnDRules\MonsterBundle\Entity\Monster 
     */
    public function getMonsterAbilityInstances()
    {
        return $this->monsterAbilityInstances;
    }

    /**
     * Set ability
     *
     * @param \DnDRules\AbilityBundle\Entity\Ability $ability
     * @return MonsterAbilityInstance
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

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return MonsterAbilityInstance
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
     * @return MonsterAbilityInstance
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
