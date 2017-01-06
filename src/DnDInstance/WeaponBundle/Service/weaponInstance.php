<?php

namespace DnDInstance\WeaponBundle\Service;

use CAS\UserBundle\Service\remove;
use DnDRules\WeaponBundle\Entity\WeaponDamage;
use Doctrine\ORM\EntityManager;
use PM\HomeBundle\Entity\Critical;
use Symfony\Component\Security\Core\SecurityContext;

class weaponInstance
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteWeapon($weaponInstance)
    {
        $this->em->remove($weaponInstance);
        $this->em->flush();
    }

    public function loadInstanceFromWeapon($weaponInstance)
    {
        $weapon = $weaponInstance->getWeapon();

        $weaponInstance->setScope($weapon->getScope());
        $weaponInstance->setWeight($weapon->getWeight());
        $weaponInstance->setHandsNumber($weapon->getHandsNumber());
        $weaponInstance->setWeaponCategory($weapon->getWeaponCategory());
        $weaponInstance->setWeaponType($weapon->getWeaponType());

        foreach($weapon->getCriticals() as $critical) {
            $criticalInstance = new Critical();
            $criticalInstance->setMultiplier($critical->getMultiplier());
            $criticalInstance->setRangeCriticalBegin($critical->getRangeCriticalBegin());
            $criticalInstance->setRangeCriticalEnd($critical->getRangeCriticalEnd());
            $criticalInstance->setWeapon($critical->getWeapon());
            $this->em->persist($criticalInstance);
        }

        foreach($weapon->getDamages() as $weaponDamage) {
            $weaponDamageInstance = new WeaponDamage();
            $weaponDamageInstance->setWeapon($weaponDamage->getWeapon());
            $weaponDamageInstance->setSize($weaponDamage->getSize());
            foreach($weaponDamage->getDamages() as $damage) {
                $weaponDamageInstance->addDamage($damage);
            }
            $this->em->persist($weaponDamageInstance);
        }

        $this->em->flush();
    }

    public function cloneWeaponInstance($weaponInstance, $characterUsedInstance=null, $game=null)
    {
        $newWeaponInstance = clone $weaponInstance;
        $newWeaponInstance->setCharacterUsedArmors($characterUsedInstance);
        $newWeaponInstance->setGame($game);
        $newWeaponInstance->setId(null);

        $this->em->persist($newWeaponInstance);
        $this->em->flush();

        return $newWeaponInstance;
    }

    public function removeCharacterFromInstance($weaponInstance, $game)
    {
        if($game != null) {
            $weaponInstance->setCharacterUsedWeapons(null);
            $weaponInstance->setGame($game);
            return $weaponInstance;
        } elseif($game == null) {
            $this->em->remove($weaponInstance);
            return null;
        }

    }
}
