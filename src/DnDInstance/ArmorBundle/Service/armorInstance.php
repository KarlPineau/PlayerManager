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
    
    public function remove($armorInstance)
    {
        /* A supprimer avec un armor :
         *  -> Armor : Entité Armor
         *  -> A voir pour le reste
         */
        
        $this->em->remove($armorInstance);
        $this->em->flush();
    }

    public function getArmors($characterUsed=null, $game=null)
    {
        if($characterUsed != null) {
            return $this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findByCharacterUsed($characterUsed);
        } elseif($game != null) {
            return $this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findByGame($game);
        }
    }

    public function getWearArmors($characterUsed)
    {
        return $this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findBy(array('characterUsed' => $characterUsed, 'wear' => true));
    }

    public function cloneArmorInstance($armorInstance, $characterUsedInstance=null, $game=null)
    {
        $newArmorInstance = clone $armorInstance;
        $newArmorInstance->setCharacterUsed($characterUsedInstance);
        $newArmorInstance->setGame($game);
        $newArmorInstance->setId(null);

        $this->em->persist($newArmorInstance);
        $this->em->flush();

        return $newArmorInstance;
    }

    public function instanceArmor($armorInstance)
    {

        $armor = $armorInstance->getArmor();

        $armorInstance->setName($armor->getName());
        $armorInstance->setType($armor->getType());

        $armorInstance->setBonus($armor->getBonus());
        $armorInstance->setDexterityBonus($armor->getDexterityBonus());
        $armorInstance->setFailRisks($armor->getFailRisks());
        $armorInstance->setTestMalus($armor->getTestMalus());

        $armorInstance->setPriceValue($armor->getPrice());
        $armorInstance->setSpeedM($armor->getSpeedM());
        $armorInstance->setSpeedP($armor->getSpeedP());
        $armorInstance->setWeight($armor->getWeight());

        $this->em->persist($armorInstance);
        $this->em->flush();

        return $armorInstance;
    }

    public function wearArmor($characterUsed, $armorInstance)
    {
        $searchType = $armorInstance->getType()->getType();

        foreach($this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findBy(array('characterUsed' => $characterUsed, 'wear' => true)) as $armorInstanceI) {
            if($searchType == $armorInstanceI->getType()->getType()) {
                $armorInstanceI->setWear(false);
                $this->em->persist($armorInstanceI);
                $this->em->flush();
            }
        }

        if($armorInstance->getCharacterUsed() == $characterUsed) {
            $armorInstance->setWear(true);
            $this->em->persist($armorInstance);
            $this->em->flush();
        }

        return $this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findOneBy(array('characterUsed' => $characterUsed, 'wear' => true));
    }

    public function discardArmor($characterUsed, $armorInstance)
    {
        /* Défausse un personnage de son armure et la met dans le jeu d'armure de la partie */

        if($armorInstance->getCharacterUsed() == $characterUsed) {
            $armorInstance->setWear(false);
            $armorInstance->setCharacterUsed(null);
            $armorInstance->setGame($characterUsed->getGame());
            $this->em->persist($armorInstance);
            $this->em->flush();
        }
    }
}
