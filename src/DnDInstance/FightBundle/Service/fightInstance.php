<?php

namespace DnDInstance\FightBundle\Service;

use DnDInstance\FightBundle\Entity\FightCharacterUsed;
use DnDInstance\FightBundle\Entity\FightMonsterInstance;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDInstance\FightBundle\Entity\Fight;

class fightInstance
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
    
    public function instanceFight($monsterInstances, $characters, $game) {
        $fight = new Fight;
        $fight->setGame($game);
        
        foreach ($monsterInstances as $monsterInstance) {
            $fightMonsterInstance = new FightMonsterInstance();
            $fightMonsterInstance->setInitiative(rand(1, 20)+$monsterInstance->getMonster()->getInitiative());
            $fightMonsterInstance->setMonsterInstance($monsterInstance);
            $fightMonsterInstance->setFight($fight);
            $this->em->persist($fightMonsterInstance);
        }
        
        foreach ($characters as $characterUsed) {
            $fightCharacterUsed = new FightCharacterUsed();
            $fightCharacterUsed->setCharacterUsed($characterUsed);
            $fightCharacterUsed->setInitiative($this->characteruseddnd->getInitiativeModifier($characterUsed));
            $fightCharacterUsed->setFight($fight);
            $this->em->persist($fightCharacterUsed);
        }
        $this->em->persist($fight);
        $this->em->flush();

        return $fight;
    }

    public function getCharacters($fightInstance)
    {
        return $this->em->getRepository('DnDInstanceFightBundle:FightCharacterUsed')->findByFight($fightInstance);
    }

    public function getMonsters($fightInstance)
    {
        return $this->em->getRepository('DnDInstanceFightBundle:FightMonsterInstance')->findByFight($fightInstance);
    }
}
