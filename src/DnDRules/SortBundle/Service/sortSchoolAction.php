<?php

namespace DnDRules\SortBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use DnDRules\SortBundle\Entity\SortSchool;

class sortSchoolAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteSortSchool($sortschool)
    {
        /* A supprimer avec un sortschool :
         *  -> SortSchool : Entité SortSchool
         *  -> A voir pour le reste
         */
        
        $this->em->remove($sortschool);
        $this->em->flush();
    }
    
    public function registerSortSchool($name)
    {
        $newSortSchool = new SortSchool();
        $newSortSchool->setName($name);
        $this->em->persist($newSortSchool);
        $this->em->flush();
    }
}
