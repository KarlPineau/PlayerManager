<?php

namespace DnDRules\RaceBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class race
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function getST($race)
    {
        return $this->em->getRepository('DnDRulesRaceBundle:RaceST')->findOneByRace($race);
    }

    public function getSkills($race)
    {
        return $this->em->getRepository('DnDRulesRaceBundle:RaceSkill')->findByRace($race);
    }

    public function getLevels($race)
    {
        return $this->em->getRepository('DnDRulesRaceBundle:RaceLevel')->findByRace($race);
    }
}
