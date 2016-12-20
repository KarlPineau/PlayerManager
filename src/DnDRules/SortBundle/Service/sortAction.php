<?php

namespace DnDRules\SortBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class sortAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteSort($sort)
    {
        /* A supprimer avec un sort :
         *  -> Sort : Entité Sort
         *  -> A voir pour le reste
         */
        
        $this->em->remove($sort);
        $this->em->flush();
    }
}
