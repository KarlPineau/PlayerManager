<?php

namespace DnDRules\ClassDnDBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class deleteClassDnD 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteClassDnD($classDnD)
    {
        /* A supprimer avec une classe :
         *  -> ClassDnD : Entité classe
         * -> A voir pour le reste
         */
        $repositoryClassDnDInstance = $this->em->getRepository('DnDRulesClassDnDBundle:ClassDnDInstance');
        $instances = $repositoryClassDnDInstance ->findBy(array('classDnD' => $classDnD));
        foreach ($instances as $instance) {
            $this->em->remove($instance);
        }
        
        $repositoryRace = $this->em->getRepository('DnDRulesRaceBundle:Race');
        $races = $repositoryRace->findBy(array('predilectionClass' => $classDnD));
        foreach ($races as $race) {
            $race->setPredilectionClass();
            $this->em->persist($race);
        }
        
        $repositoryClassST = $this->em->getRepository('DnDRulesClassDnDBundle:ClassST');
        $classSTs = $repositoryClassST->findBy(array('classDnD' => $classDnD));
        foreach ($classSTs as $classST) {
            $this->em->remove($classST);
        }
        
        $repositoryClassBAB = $this->em->getRepository('DnDRulesClassDnDBundle:ClassBAB');
        $classBABs = $repositoryClassBAB->findBy(array('classDnD' => $classDnD));
        foreach ($classBABs as $classBAB) {
            $this->em->remove($classBAB);
        }
        
        $this->em->remove($classDnD);
        $this->em->flush();
    }
}
