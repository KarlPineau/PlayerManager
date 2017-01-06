<?php

namespace DnDInstance\ClassDnDBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class classDnDInstance
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteClassDnDInstance($classDnDInstance)
    {
        /* A supprimer avec un armor :
         *  -> Armor : Entité Armor
         *  -> A voir pour le reste
         */
        
        $this->em->remove($classDnDInstance);
        $this->em->flush();
    }

    public function cloneClassDnDInstance($classDnDInstance, $characterUsedDnDInstance)
    {
        $newClassDnDInstance = clone $classDnDInstance;
        $newClassDnDInstance->setCharacterUsedDnDInstance($characterUsedDnDInstance);
        $newClassDnDInstance->setId(null);

        $this->em->persist($newClassDnDInstance);
        $this->em->flush();

        return $newClassDnDInstance;
    }
}
