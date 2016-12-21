<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedAction
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteCharacterUsed($characterUsed)
    {
        /* A supprimer avec un personnage :
         *  -> DONE : Ability : caractéristiques du personnage
         *  -> (CASCADE : CharacterLanguage : langues du personnage)
         *  -> DONE : CharacterSkill : compétences du personnage
         *  -> DONE : CharacterWealth : richesse du personnage -> Cascade remove
         *  -> DONE : ClassDnDInstance : classe du personnage
         *  -> DONE : XpPoints : XP du personnage
         */
        
        $repositoryAbility = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterAbility');
        $abilities = $repositoryAbility->findBy(array('characterUsed' => $characterUsed));
        foreach ($abilities as $abilitie) {
            $this->em->remove($abilitie);
        }
        
        $repositoryCharacterSkills = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterSkill');
        $skills = $repositoryCharacterSkills->findBy(array('characterUsedSkills' => $characterUsed));
        foreach ($skills as $skill) {
            $this->em->remove($skill);
        }
        
        $repositoryClassDnDInstance = $this->em->getRepository('DnDInstanceClassDnDBundle:ClassDnDInstance');
        $instances = $repositoryClassDnDInstance->findBy(array('characterUsedDnDInstance' => $characterUsed));
        foreach ($instances as $instance) {
            $this->em->remove($instance);
        }

        $repositoryXpPoints = $this->em->getRepository('DnDInstanceCharacterBundle:XpPoints');
        $xpPoints = $repositoryXpPoints->findBy(array('characterUsed' => $characterUsed));
        foreach ($xpPoints as $xpPoint) {
            $this->em->remove($xpPoint);
        }

        $this->em->remove($characterUsed->getWealth());
        $this->em->remove($characterUsed);
        $this->em->flush();
    }
}
