<?php

namespace DnDRules\AlignmentBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class deleteAlignment 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteAlignment($alignment)
    {
        /* A supprimer avec un alignement :
         *  -> Alignment : Entité alignement
         *  -> CharacterUsed.Alignment : Personnage ayant un alignement de ce type
         *  -> Monster.Alignment : Monstre ayant un alignement de ce type
         */
        $repositoryCharacterUsed = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUseds = $repositoryCharacterUsed->findByAlignment($alignment);
        
        foreach ($characterUseds as $characterUsed) {
            $characterUsed->setAlignment();
            $this->em->persist($characterUsed);
        }
        
        $repositoryMonster = $this->em->getRepository('DnDRulesMonsterBundle:Monster');
        $monsters = $repositoryMonster->findByAlignment($alignment);
        
        foreach ($monsters as $monster) {
            $monster->setAlignment();
            $this->em->persist($monster);
        }
        
        $this->em->remove($alignment);
        $this->em->flush();
    }
}
