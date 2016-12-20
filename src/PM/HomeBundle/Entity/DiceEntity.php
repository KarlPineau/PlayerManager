<?php

namespace PM\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DiceEntity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PM\HomeBundle\Entity\DiceEntityRepository")
 */
class DiceEntity
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
     * @ORM\ManyToOne(targetEntity="PM\HomeBundle\Entity\DiceForm", inversedBy="diceEntities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $diceForm;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="diceNumber", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $diceNumber;

    /**
     * @ORM\ManyToOne(targetEntity="PM\HomeBundle\Entity\DiceType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $diceType;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createDate", type="datetime", nullable=false)
     */
    protected $createDate;


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
     * Set diceNumber
     *
     * @param integer $diceNumber
     * @return DiceEntity
     */
    public function setDiceNumber($diceNumber)
    {
        $this->diceNumber = $diceNumber;

        return $this;
    }

    /**
     * Get diceNumber
     *
     * @return integer 
     */
    public function getDiceNumber()
    {
        return $this->diceNumber;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return DiceEntity
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
     * Set diceForm
     *
     * @param \PM\HomeBundle\Entity\DiceForm $diceForm
     * @return DiceEntity
     */
    public function setDiceForm(\PM\HomeBundle\Entity\DiceForm $diceForm = null)
    {
        $this->diceForm = $diceForm;

        return $this;
    }

    /**
     * Get diceForm
     *
     * @return \PM\HomeBundle\Entity\DiceForm 
     */
    public function getDiceForm()
    {
        return $this->diceForm;
    }

    /**
     * Set diceType
     *
     * @param \PM\HomeBundle\Entity\DiceType $diceType
     * @return DiceEntity
     */
    public function setDiceType(\PM\HomeBundle\Entity\DiceType $diceType)
    {
        $this->diceType = $diceType;

        return $this;
    }

    /**
     * Get diceType
     *
     * @return \PM\HomeBundle\Entity\DiceType 
     */
    public function getDiceType()
    {
        return $this->diceType;
    }
}
