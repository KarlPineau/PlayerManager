<?php

namespace PM\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PM\HomeBundle\Entity\DiceRepository")
 */
class Dice
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
     * @ORM\ManyToOne(targetEntity="PM\HomeBundle\Entity\DiceType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $diceType;

    /**
     * @var integer
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="DiceResult", type="smallint")
     */
    private $diceResult;
    
    /**
     * @ORM\ManyToOne(targetEntity="Game\GameBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;
    
    /**
     * @ORM\ManyToOne(targetEntity="DnDInstance\CharacterBundle\Entity\CharacterUsed")
     * @ORM\JoinColumn(nullable=false)
     */
    private $characterUsed;

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
     * Set diceResult
     *
     * @param integer $diceResult
     * @return Dice
     */
    public function setDiceResult($diceResult)
    {
        $this->diceResult = $diceResult;

        return $this;
    }

    /**
     * Get diceResult
     *
     * @return integer 
     */
    public function getDiceResult()
    {
        return $this->diceResult;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Dice
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
     * Set diceType
     *
     * @param \PM\HomeBundle\Entity\DiceType $diceType
     * @return Dice
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

    /**
     * Set game
     *
     * @param \Game\GameBundle\Entity\Game $game
     * @return Dice
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
     * Set characterUsed
     *
     * @param \DnDInstance\CharacterBundle\Entity\CharacterUsed $characterUsed
     * @return Dice
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
