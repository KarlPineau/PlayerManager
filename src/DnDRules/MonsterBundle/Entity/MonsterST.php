<?php

namespace DnDRules\MonsterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MonsterST
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDRules\MonsterBundle\Entity\MonsterSTRepository")
 */
class MonsterST
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
     * @ORM\JoinColumn(nullable=true)
     */
    protected $monster;

    /**
     * @var integer
     *
     * @ORM\Column(name="fortitude", type="integer", nullable=true, options={"default" = 0})
     */
    private $fortitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="reflex", type="integer", nullable=true, options={"default" = 0})
     */
    private $reflex;

    /**
     * @var integer
     *
     * @ORM\Column(name="will", type="integer", nullable=true, options={"default" = 0})
     */
    private $will;

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
     * Set fortitude
     *
     * @param integer $fortitude
     * @return MonsterST
     */
    public function setFortitude($fortitude)
    {
        $this->fortitude = $fortitude;

        return $this;
    }

    /**
     * Get fortitude
     *
     * @return integer 
     */
    public function getFortitude()
    {
        return $this->fortitude;
    }

    /**
     * Set reflex
     *
     * @param integer $reflex
     * @return MonsterST
     */
    public function setReflex($reflex)
    {
        $this->reflex = $reflex;

        return $this;
    }

    /**
     * Get reflex
     *
     * @return integer 
     */
    public function getReflex()
    {
        return $this->reflex;
    }

    /**
     * Set will
     *
     * @param integer $will
     * @return MonsterST
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return integer 
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return MonsterST
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
     * @return MonsterST
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
     * @return MonsterST
     */
    public function setMonster(\DnDRules\MonsterBundle\Entity\Monster $monster = null)
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
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return MonsterST
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
     * @return MonsterST
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
