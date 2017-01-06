<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedXpPoints
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function getXpPoints ($characterUsed) {
        $repositoryXpPoints = $this->em->getRepository('DnDInstanceCharacterBundle:XpPoints');
	$xpPoints = $repositoryXpPoints->findOneBy(array('characterUsedDnDXpPoints' => $characterUsed));
        
        return $xpPoints;
    }

    public function cloneXpPointInstance($xpPoints, $characterUsed)
    {
        $newXpPoints = clone $xpPoints;
        $newXpPoints->setCharacterUsed($characterUsed);
        $newXpPoints->setId(null);

        $this->em->persist($newXpPoints);
        $this->em->flush();

        return $newXpPoints;
    }
}
