<?php

namespace DnDInstance\MonsterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDInstance\MonsterBundle\Entity\MonsterInstance;

class monsterGenerate
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function generateMonster($monsterType, $number, $game) { 
        for ($index = 1; $index <= $number; $index++) {
            $bonusHp = 0;
            $diceEntitiesHp = 0;
            foreach ($monsterType->getHpForm() as $hpForm) {
                foreach ($hpForm->getDiceEntities() as $diceEntity) {
                     for ($indexDiceEntity = 1; $indexDiceEntity <= $diceEntity->getDiceNumber(); $indexDiceEntity++) {
                         $diceEntitiesHp .= rand(1, $diceEntity->getDiceType()->getDice());
                     }
                }
                foreach ($hpForm->getBonusNumbers() as $bonus) {
                    $bonusHp .= $bonus->getValue();
                }
            }
            $hp = $diceEntitiesHp+$bonusHp;
            
            $monsterInstance = new MonsterInstance;
            $monsterInstance->setMonster($monsterType);
            $monsterInstance->setGame($game);
            $monsterInstance->setHpCurrent($hp);
            $monsterInstance->setHpMax($hp);
            $monsterInstance->setName($monsterType->getName().' '.uniqid());
            $this->em->persist($monsterInstance);
        }
        $this->em->flush();
    }
    
    public function deleteMonsterInstance($monsterInstance)
    {
        /* A supprimer avec un personnage :
         */
        
        $this->em->remove($monsterInstance);
        $this->em->flush();
    }
}
