<?php

namespace PM\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BonusNumber
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PM\HomeBundle\Entity\BonusNumberRepository")
 */
class BonusNumber
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
     * @ORM\ManyToOne(targetEntity="PM\HomeBundle\Entity\DiceForm", inversedBy="bonusNumbers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $diceForm;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

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
     * Set value
     *
     * @param integer $value
     * @return BonusNumber
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
     * @return BonusNumber
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
     * @return BonusNumber
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
}
