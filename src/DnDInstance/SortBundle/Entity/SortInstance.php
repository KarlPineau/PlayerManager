<?php

namespace DnDInstance\SortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SortInstance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DnDInstance\SortBundle\Entity\SortInstanceRepository")
 */
class SortInstance
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
     * @ORM\ManyToOne(targetEntity="DnDRules\SortBundle\Entity\Sort")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sort;

    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characterUsed;

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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return SortInstance
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
     * @return SortInstance
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
     * Set sort
     *
     * @param \DnDRules\SortBundle\Entity\Sort $sort
     * @return SortInstance
     */
    public function setSort(\DnDRules\SortBundle\Entity\Sort $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return \DnDRules\SortBundle\Entity\Sort 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set createUser
     *
     * @param \CAS\UserBundle\Entity\User $createUser
     * @return SortInstance
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
     * @return SortInstance
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
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return SortInstance
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
}
