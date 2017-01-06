<?php

namespace DnDInstance\ArmorBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class armorInstance
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteArmorInstance($armorInstance)
    {
        /* A supprimer avec un armor :
         *  -> Armor : Entité Armor
         *  -> A voir pour le reste
         */
        
        $this->em->remove($armorInstance);
        $this->em->flush();
    }

    public function cloneArmorInstance($armorInstance, $characterUsedInstance=null, $game=null)
    {
        $newArmorInstance = clone $armorInstance;
        $newArmorInstance->setCharacterUsedArmors($characterUsedInstance);
        $newArmorInstance->setGame($game);
        $newArmorInstance->setId(null);

        $this->em->persist($newArmorInstance);
        $this->em->flush();

        return $newArmorInstance;
    }
}
