<?php

namespace DnDInstance\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharacterWealth
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\CharacterBundle\Entity\CharacterWealthRepository")
 */
class CharacterWealth
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $characterUsedWealth;

    /**
     * @var integer
     *
     * @ORM\Column(name="po", type="integer", options={"default" = 0}, nullable=false)
     */
    private $po;

    /**
     * @var integer
     *
     * @ORM\Column(name="pa", type="integer", options={"default" = 0}, nullable=false)
     */
    private $pa;

    /**
     * @var integer
     *
     * @ORM\Column(name="pc", type="integer", options={"default" = 0}, nullable=false)
     */
    private $pc;

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
     * Set po
     *
     * @param integer $po
     * @return CharacterWealth
     */
    public function setPo($po)
    {
        $this->po = $po;

        return $this;
    }

    /**
     * Get po
     *
     * @return integer 
     */
    public function getPo()
    {
        return $this->po;
    }

    /**
     * Set pa
     *
     * @param integer $pa
     * @return CharacterWealth
     */
    public function setPa($pa)
    {
        $this->pa = $pa;

        return $this;
    }

    /**
     * Get pa
     *
     * @return integer 
     */
    public function getPa()
    {
        return $this->pa;
    }

    /**
     * Set pc
     *
     * @param integer $pc
     * @return CharacterWealth
     */
    public function setPc($pc)
    {
        $this->pc = $pc;

        return $this;
    }

    /**
     * Get pc
     *
     * @return integer 
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return CharacterWealth
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
     * @return CharacterWealth
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return CharacterWealth
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
     * @return CharacterWealth
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
     * Set characterUsedWealth
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedWealth
     * @return CharacterWealth
     */
    public function setCharacterUsedWealth(\DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsedWealth = null)
    {
        $this->characterUsedWealth = $characterUsedWealth;

        return $this;
    }

    /**
     * Get characterUsedWealth
     *
     * @return \DnDInstance\CharacterBundle\Entity\CharacterUsed 
     */
    public function getCharacterUsedWealth()
    {
        return $this->characterUsedWealth;
    }
}
