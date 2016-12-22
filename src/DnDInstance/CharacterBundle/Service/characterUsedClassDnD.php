<?php

namespace DnDInstance\CharacterBundle\Service;

use DnDInstance\ArmorBundle\Entity\ArmorInstance;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use \DnDInstance\CharacterBundle\Entity\XpPoints;
use \DnDRules\WeaponBundle\Entity\Weapon;

class characterUsedClassDnD
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function getMainClassDnD($characterUsed) {
        $return = null;
        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $return = $classDnDInstance->getClassDnD();
        }

        return $return;
    }

    public function getMainClassDnDInstance($characterUsed) {
        $return = null;
        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $return = $classDnDInstance;
        }

        return $return;
    }

    public function getMainLevel($characterUsed) {
        $return = null;
        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $return = $classDnDInstance->getLevel()->getLevel();
        }

        return $return;
    }

    public function getMainLevelInstance($characterUsed) {
        $return = null;
        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $return = $classDnDInstance->getLevel();
        }

        return $return;
    }
}
