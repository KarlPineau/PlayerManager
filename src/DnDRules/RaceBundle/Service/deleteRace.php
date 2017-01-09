<?php

namespace DnDRules\RaceBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class deleteRace
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteRace($race)
    {
        /* A supprimer avec une race :
         *  -> Race : Entité race
         * -> A voir pour le reste
         */
        $repositoryRaceAbility = $this->em->getRepository('DnDRulesRaceBundle:RaceAbility');
        $raceAbilities = $repositoryRaceAbility->findByRace($race);
        foreach ($raceAbilities as $raceAbility) {
            $this->em->remove($raceAbility);
        }

        $this->em->remove($this->em->getRepository('DnDRulesRaceBundle:RaceST')->findOneByRace($race));
        
        $this->em->remove($race);
        $this->em->flush();
    }
}
