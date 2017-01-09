<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedGift
{
    protected $em;
    protected $security;
    protected $characterusedability;
    protected $characterusedclassdnd;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, CharacterUsedAbility $characterusedability, characterUsedClassDnD $characterUsedClassDnD)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->characterusedability = $characterusedability;
        $this->characterusedclassdnd = $characterUsedClassDnD;
    }
    
    public function getAllowedGiftsNumber($characterUsed) {
        $countGiftAllowed = 0;

        for($levelI = 0; $levelI <= $this->characterusedclassdnd->getMainLevel($characterUsed); $levelI++) {
            if($this->em->getRepository('DnDRulesLevelBundle:Level')->findOneByLevel($levelI)->getGift() == true) {
                $countGiftAllowed++;
            }

            if($this->em->getRepository('DnDRulesRaceBundle:RaceLevel')->findOneBy(array('race' => $characterUsed->getRace(), 'level' => $levelI)) != null and
                $this->em->getRepository('DnDRulesRaceBundle:RaceLevel')->findOneBy(array('race' => $characterUsed->getRace(), 'level' => $levelI))->getGift() == true) {
                $countGiftAllowed++;
            }
        }

        return $countGiftAllowed;
    }
}
