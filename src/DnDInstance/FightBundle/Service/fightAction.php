<?php

namespace DnDInstance\FightBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDInstance\FightBundle\Entity\Fight;

class fightAction
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteFight($fight)
    {
        foreach($this->em->getRepository('DnDInstanceFightBundle:FightCharacterUsed')->findByFight($fight) as $fightCharacterUsed) {
            $this->em->remove($fightCharacterUsed);
        }

        foreach($this->em->getRepository('DnDInstanceFightBundle:FightMonsterInstance')->findByFight($fight) as $fightMonsterInstance) {
            $this->em->remove($fightMonsterInstance);
        }

        $this->em->remove($fight);
        $this->em->flush();
    }
}
