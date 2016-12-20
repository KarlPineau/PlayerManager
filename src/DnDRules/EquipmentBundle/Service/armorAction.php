<?php

namespace DnDRules\EquipmentBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class equipmentAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteEquipment($equipment)
    {
        /* A supprimer avec un equipment :
         *  -> Equipment : Entité Equipment
         *  -> A voir pour le reste
         */
        
        $this->em->remove($equipment);
        $this->em->flush();
    }
}
