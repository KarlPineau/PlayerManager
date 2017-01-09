<?php

namespace DnDInstance\WeaponBundle\Service;

use CAS\UserBundle\Service\remove;
use DnDRules\WeaponBundle\Entity\WeaponDamage;
use Doctrine\ORM\EntityManager;
use PM\HomeBundle\Entity\BonusNumber;
use PM\HomeBundle\Entity\Critical;
use PM\HomeBundle\Entity\DiceEntity;
use PM\HomeBundle\Entity\DiceForm;
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
    
    public function remove($weaponInstance)
    {
        $this->em->remove($weaponInstance);
        $this->em->flush();
    }

    public function instanceWeapon($weaponInstance)
    {
        $weapon = $weaponInstance->getWeapon();

        $weaponInstance->setName($weapon->getName());

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
            $criticalInstance->setWeaponInstance($weaponInstance);
            $this->em->persist($criticalInstance);
        }

        foreach($weapon->getDamages() as $weaponDamage) {
            $weaponDamageInstance = new WeaponDamage();
            $weaponDamageInstance->setWeaponInstance($weaponInstance);
            $weaponDamageInstance->setSize($weaponDamage->getSize());
            $weaponInstance->addDamage($weaponDamageInstance);

            $diceForms = $weaponDamage->getDamages();
            foreach ($diceForms as $diceForm) {
                $diceFormInstance = new DiceForm();
                $diceFormInstance->setWeaponDamage($weaponDamageInstance);
                $weaponDamageInstance->addDamage($diceFormInstance);

                $diceEntities = $diceForm->getDiceEntities();
                foreach ($diceEntities as $diceEntity) {
                    $diceEntityInstance = new DiceEntity();
                    $diceFormInstance->addDiceEntity($diceEntityInstance);
                    $diceEntityInstance->setDiceForm($diceFormInstance);
                    $diceEntityInstance->setDiceNumber($diceEntity->getDiceNumber());
                    $diceEntityInstance->setDiceType($diceEntity->getDiceType());
                    $this->em->persist($diceEntityInstance);
                }

                $bonusNumbers = $diceForm->getBonusNumbers();
                foreach ($bonusNumbers as $bonusNumber) {
                    $bonusNumberInstance = new BonusNumber();
                    $diceFormInstance->addBonusNumber($bonusNumberInstance);
                    $bonusNumberInstance->setDiceForm($diceFormInstance);
                    $bonusNumberInstance->setValue($bonusNumber->getValue());
                    $this->em->persist($bonusNumberInstance);
                }
                $this->em->persist($diceForm);
            }
            $this->em->persist($weaponDamageInstance);
        }

        $this->em->flush();
        return $weaponInstance;
    }

    public function cloneWeaponInstance($weaponInstance, $characterUsedInstance=null, $game=null)
    {
        $newWeaponInstance = clone $weaponInstance;
        $newWeaponInstance->setCharacterUsed($characterUsedInstance);
        $newWeaponInstance->setGame($game);
        $newWeaponInstance->setId(null);

        $this->em->persist($newWeaponInstance);
        $this->em->flush();

        return $newWeaponInstance;
    }

    public function removeFromCharacter($weaponInstance, $characterUsed, $game)
    {
        if($game != null) {
            $weaponInstance->setGame($game);
            $weaponInstance->setCharacterUsed(null);
            $this->em->persist($weaponInstance);
            $this->em->persist($characterUsed);
            $this->em->flush();
            return $weaponInstance;
        } elseif($game == null) {
            $characterUsed->removeWeapon($weaponInstance);
            $this->em->remove($weaponInstance);
            $this->em->flush();
            return null;
        }

    }

    public function getWeapons($characterUsed=null, $game=null)
    {
        if($characterUsed != null) {
            return $this->em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findByCharacterUsed($characterUsed);
        } elseif($game != null) {
            return $this->em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findByGame($game);
        }
    }
}
