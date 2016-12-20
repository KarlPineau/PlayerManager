<?php

namespace DnDInstance\FightBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDInstance\FightBundle\Entity\Fight;

class fightGenerate
{
    protected $em;
    protected $security;
    protected $characteruseddnd;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, \DnDInstance\CharacterBundle\Service\characterUsedDnD $characteruseddnd)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->characteruseddnd = $characteruseddnd;
    }
    
    public function generateFight($monsterInstances, $characters, $game) { 
        $fight = new Fight;
        $fight->setGame($game);
        
        foreach ($monsterInstances as $monsterInstance) {
            $fightMonsterInstance = new \DnDInstance\FightBundle\Entity\FightMonsterInstance;
            $fightMonsterInstance->setInitiative(rand(1, 20)); //ATTENTION, il faut ajouter le modificateur du monstre ici
            $fightMonsterInstance->setMonsterInstance($monsterInstance);
            $fight->addFightMonsterInstance($fightMonsterInstance);
            $this->em->persist($fightMonsterInstance);
        }
        
        foreach ($characters as $characterUsed) {
            $fightCharacterUsed = new \DnDInstance\FightBundle\Entity\FightCharacterUsed;
            $fightCharacterUsed->setCharacterUsed($characterUsed);
            $fightCharacterUsed->setInitiative($this->characteruseddnd->getInitiativeModifier($characterUsed));
            $fight->addFightCharacter($fightCharacterUsed);
            $this->em->persist($fightCharacterUsed);
        }
        $this->em->persist($fight);
        $this->em->flush();
    }
}
