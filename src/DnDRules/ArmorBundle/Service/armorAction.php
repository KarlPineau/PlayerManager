<?php

namespace DnDRules\ArmorBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class armorAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteArmor($armor)
    {
        /* A supprimer avec un armor :
         *  -> Armor : Entité Armor
         *  -> A voir pour le reste
         */
        
        $this->em->remove($armor);
        $this->em->flush();
    }
}
