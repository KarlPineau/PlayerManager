<?php

namespace DnDRules\SortBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDRules\SortBundle\Entity\Composante;

class composanteAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteComposante($composante)
    {
        /* A supprimer avec un composante :
         *  -> Composante : Entité Composante
         *  -> A voir pour le reste
         */
        
        $this->em->remove($composante);
        $this->em->flush();
    }
    
    public function registerComposante($name)
    {
        $newComposante = new Composante();
        $newComposante->setName($name);
        $newComposante->setInitial($name);
        $this->em->persist($newComposante);
        $this->em->flush();
    }
}
