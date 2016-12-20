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
        $this->em->remove($fight);
        $this->em->flush();
    }
}
