<?php

namespace DnDRules\ArmorBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class deleteArmorType 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteArmorType($armortype)
    {
        /* A supprimer avec une taille :
         *  -> ArmorType : Entité Caractéristique
         *  -> A voir pour le reste
         */
        
        $this->em->remove($armortype);
        $this->em->flush();
    }
}
