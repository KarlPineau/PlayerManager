<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassSpecificities
 *
 * @ORM\Entity
 */
class ClassSpecificities
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
     * @ORM\OneToMany(targetEntity="DnDRules\ClassDnDBundle\Entity\ClassSpecificity", mappedBy="classSpecificity")
     * @ORM\JoinColumn(nullable=true)
     */
    private $classSpecificities;


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
     * Constructor
     */
    public function __construct()
    {
        $this->classSpecificities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add classSpecificities
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassSpecificity $classSpecificities
     * @return ClassSpecificities
     */
    public function addClassSpecificity(\DnDRules\ClassDnDBundle\Entity\ClassSpecificity $classSpecificities)
    {
        $this->classSpecificities[] = $classSpecificities;

        return $this;
    }

    /**
     * Remove classSpecificities
     *
     * @param \DnDRules\ClassDnDBundle\Entity\ClassSpecificity $classSpecificities
     */
    public function removeClassSpecificity(\DnDRules\ClassDnDBundle\Entity\ClassSpecificity $classSpecificities)
    {
        $this->classSpecificities->removeElement($classSpecificities);
    }

    /**
     * Get classSpecificities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassSpecificities()
    {
        return $this->classSpecificities;
    }
}
