<?php

namespace DnDRules\SortBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDRules\SortBundle\Entity\Domain;

class domainAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteDomain($domain)
    {
        /* A supprimer avec un domain :
         *  -> Domain : Entité Domain
         *  -> A voir pour le reste
         */
        
        $this->em->remove($domain);
        $this->em->flush();
    }
    
    public function registerDomain($name)
    {
        $newDomain = new Domain();
        $newDomain->setName($name);
        $this->em->persist($newDomain);
        $this->em->flush();
    }
}
