<?php

namespace DnDInstance\CharacterBundle\Service;

use DnDInstance\ArmorBundle\Service\armorInstance;
use DnDInstance\ClassDnDBundle\Service\classDnDInstance;
use DnDInstance\EquipmentBundle\Service\equipmentInstance;
use DnDInstance\SortBundle\Service\sortInstance;
use DnDInstance\WeaponBundle\Service\weaponInstance;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedAction
{
    protected $em;
    protected $security;
    protected $armorInstance;
    protected $weaponInstance;
    protected $characterWealth;
    protected $characterUsedSkill;
    protected $classDnDInstance;
    protected $equipmentInstance;
    protected $sortInstance;
    protected $abilityInstance;
    protected $xpPointInstance;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, armorInstance $armorInstance, weaponInstance $weaponInstance, characterUsedWealth $characterUsedWealth, characterUsedSkill $characterUsedSkill, classDnDInstance $classDnDInstance, equipmentInstance $equipmentInstance, sortInstance $sortInstance, characterUsedAbility $characterUsedAbility, characterUsedXpPoints $characterUsedXpPoints)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->armorInstance = $armorInstance;
        $this->weaponInstance = $weaponInstance;
        $this->characterWealth = $characterUsedWealth;
        $this->characterUsedSkill = $characterUsedSkill;
        $this->classDnDInstance = $classDnDInstance;
        $this->equipmentInstance = $equipmentInstance;
        $this->sortInstance = $sortInstance;
        $this->abilityInstance = $characterUsedAbility;
        $this->xpPointInstance = $characterUsedXpPoints;
    }
    
    public function deleteCharacterUsed($characterUsed)
    {
        /* A supprimer avec un personnage :
         *  -> DONE : Ability : caractéristiques du personnage
         *  -> (CASCADE : CharacterLanguage : langues du personnage)
         *  -> DONE : CharacterSkill : compétences du personnage
         *  -> DONE : CharacterWealth : richesse du personnage -> Cascade remove
         *  -> DONE : ClassDnDInstance : classe du personnage
         *  -> DONE : XpPoints : XP du personnage
         */
        
        $abilities = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterAbility')->findBy(array('characterUsedDnDAbilities' => $characterUsed));
        $skills = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterSkill')->findBy(array('characterUsedSkills' => $characterUsed));
        $instances = $this->em->getRepository('DnDInstanceClassDnDBundle:ClassDnDInstance')->findBy(array('characterUsedDnDInstance' => $characterUsed));
        $xpPoints = $this->em->getRepository('DnDInstanceCharacterBundle:XpPoints')->findBy(array('characterUsedDnDXpPoints' => $characterUsed));
        $armors = $this->em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findBy(array('characterUsedArmors' => $characterUsed));
        $weapons = $this->em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findBy(array('characterUsedWeapons' => $characterUsed));
        $equipments = $this->em->getRepository('DnDInstanceSortBundle:SortInstance')->findBy(array('characterUsedSorts' => $characterUsed));
        $sorts = $this->em->getRepository('DnDInstanceEquipmentBundle:EquipmentInstance')->findBy(array('characterUsedEquipments' => $characterUsed));
        $entities = array_merge($abilities, $skills, $instances, $xpPoints, $armors, $weapons, $equipments, $sorts);

        foreach ($entities as $entity) {
            $this->em->remove($entity);
        }

        foreach($this->em->getRepository('DnDInstanceFightBundle:FightCharacterUsed')->findBy(array('characterUsed' => $characterUsed)) as $fightCharacterUsed) {
            foreach($fightCharacterUsed->getFightCharacters() as $fight) {
                $fight->removeFightCharacter($fightCharacterUsed);
            }
            $this->em->remove($fightCharacterUsed);
        }

        $this->em->remove($characterUsed);
        $this->em->flush();
    }

    public function cloneCharacterUsed($characterUsed)
    {
        $newCharacterUsed = clone $characterUsed;
        $newCharacterUsed->setId(null);
        foreach($newCharacterUsed->getArmors() as $armorInstance) {$newCharacterUsed->removeArmor($armorInstance);}
        foreach($newCharacterUsed->getWeapons() as $weaponInstance) {$newCharacterUsed->removeWeapon($weaponInstance);}
        foreach($newCharacterUsed->getClassDnDInstances() as $classDnDInstance) {$newCharacterUsed->removeClassDnDInstance($classDnDInstance);}
        foreach($newCharacterUsed->getSkills() as $characterUsedSkill) {$newCharacterUsed->removeSkill($characterUsedSkill);}
        foreach($newCharacterUsed->getEquipments() as $equipementInstance) {$newCharacterUsed->removeEquipment($equipementInstance);}
        foreach($newCharacterUsed->getSorts() as $sortInstance) {$newCharacterUsed->removeSort($sortInstance);}
        $this->em->persist($characterUsed);
        $this->em->flush();

        foreach($characterUsed->getArmors() as $armorInstance) {
            $newCharacterUsed->addArmor($this->armorInstance->cloneArmorInstance($armorInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getWeapons() as $weaponInstance) {
            $newCharacterUsed->addWeapon($this->weaponInstance->cloneWeaponInstance($weaponInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $newCharacterUsed->addClassDnDInstance($this->classDnDInstance->cloneClassDnDInstance($classDnDInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getSkills() as $characterUsedSkill) {
            $newCharacterUsed->addSkill($this->characterUsedSkill->cloneCharacterUsedSkill($characterUsedSkill, $newCharacterUsed));
        }

        foreach($characterUsed->getEquipments() as $equipmentInstance) {
            $newCharacterUsed->addEquipment($this->equipmentInstance->cloneEquipmentInstance($equipmentInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getSorts() as $sortInstance) {
            $newCharacterUsed->addSort($this->sortInstance->cloneSortInstance($sortInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getAbilities() as $abilityInstance) {
            $newCharacterUsed->addAbility($this->abilityInstance->cloneCharacterUsedAbility($abilityInstance, $newCharacterUsed));
        }

        foreach($characterUsed->getXpPoints() as $xpPointInstance) {
            $newCharacterUsed->addXpPoint($this->xpPointInstance->cloneXpPointInstance($xpPointInstance, $newCharacterUsed));
        }

        $this->characterWealth->cloneWealth($characterUsed->getWealth(), $newCharacterUsed);

        $this->em->persist($characterUsed);
        $this->em->flush();

        return $newCharacterUsed;
    }
}
