<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedAbility
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function getAbility ($characterUsed, $ability, $detail=false) {
        $repositoryCharacterAbility = $this->em->getRepository('DnDInstanceCharacterBundle:CharacterAbility');
	$abilityBase = $repositoryCharacterAbility->findOneBy(array('characterUsedDnDAbilities' => $characterUsed, 'ability' => $ability));
        $repositoryRaceAbility = $this->em->getRepository('DnDRulesRaceBundle:RaceAbility');
	$abilityRace = $repositoryRaceAbility->findOneBy(array('race' => $characterUsed->getRace(), 'ability' => $ability));

        if($detail == true) {$abilityValue = '<abbr title="Valeur de Caractéristique">'.$abilityBase->getValue().'</abbr> + <abbr title="Modificateur de Race">'.$abilityRace->getValue().'</abbr>';}
        else {$abilityValue = $abilityBase->getValue() + $abilityRace->getValue();}
        
	return $abilityValue;
    }
    
    public function getAbilityModifier($abilityValue) { 
        //Fonction retournant le modificateur d’une caractéristique
        
        $abilityModifier = 0;
        if($abilityValue >= 10) {
            if($abilityValue == 10 OR $abilityValue == 11) {
                $abilityModifier = 0;
            }
            else {
                if($abilityValue%2 == 0) { //Nombre pair
                    $abilityModifier = ($abilityValue-10)/2;
                }
                elseif($abilityValue%2 == 1) { //Nombre impair
                    $abilityModifier = ($abilityValue-11)/2;
                }
            }
        }
        elseif($abilityValue < 10) {
            switch ($abilityValue) {
                case 1:
                    $abilityModifier = -5;
                    break;
                case 2:
                    $abilityModifier = -4;
                    break;
                case 3:
                    $abilityModifier = -4;
                    break;
                case 4:
                    $abilityModifier = -3;
                    break;
                case 5:
                    $abilityModifier = -3;
                    break;
                case 6:
                    $abilityModifier = -2;
                    break;
                case 7:
                    $abilityModifier = -2;
                    break;
                case 8:
                    $abilityModifier = -1;
                    break;
                case 9:
                    $abilityModifier = -1;
                    break;
            }
        }

        return $abilityModifier;
    }
    
    public function getStrength($characterUsed, $detail=false) { 
        // Retourne la Force du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 1));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getStrengthModifier($characterUsed) { 
        // Retourne le Modificateur de Force du Personnage
        $strength = $this->getStrength($characterUsed);
        $strengthModifier = $this->getAbilityModifier($strength);

        return $strengthModifier;
    }

    public function getDexterity($characterUsed, $detail=false) { 
        // Retourne la Dextérité du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 2));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getDexterityModifier($characterUsed) { 
        // Retourne le Modificateur de Dextérité du Personnage
        $dexterity = $this->getDexterity($characterUsed);
        $dexterityModifier = $this->getAbilityModifier($dexterity);

        return $dexterityModifier;
    }

    public function getConstitution($characterUsed, $detail=false) { 
        // Retourne la Constitution du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 3));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getConstitutionModifier($characterUsed) { 
        // Retourne le Modificateur de Intelligence du Personnage
        $constitution = $this->getConstitution($characterUsed);
        $constitutionModifier = $this->getAbilityModifier($constitution);

        return $constitutionModifier;
    }


    public function getIntelligence($characterUsed, $detail=false) { 
        // Retourne l'Intelligence du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 4));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getIntelligenceModifier($characterUsed) { 
        // Retourne le Modificateur de Intelligence du Personnage
        $intelligence = $this->getIntelligence($characterUsed);
        $intelligenceModifier = $this->getAbilityModifier($intelligence);

        return $intelligenceModifier;
    }

    public function getWisdom($characterUsed, $detail=false) { 
        // Retourne la Sagesse du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 5));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getWisdomModifier($characterUsed) { 
        // Retourne le Modificateur de Sagesse du Personnage
        $wisdom = $this->getWisdom($characterUsed);
        $wisdomModifier = $this->getAbilityModifier($wisdom);

        return $wisdomModifier;
    }

    public function getCharisma($characterUsed, $detail=false) { 
        //Retourne le Charisme du Personnage
        $repositoryAbility = $this->em->getRepository('DnDRulesAbilityBundle:Ability');
	$ability = $repositoryAbility->findOneBy(array('type' => 6));
        return $this->getAbility($characterUsed, $ability, $detail);
    }

    public function getCharismaModifier($characterUsed) { 
        //Retourne le Modificateur de Charisme du Personnage
        $charisma = $this->getCharisma($characterUsed);
        $charismaModifier = $this->getAbilityModifier($charisma);
        
        return $charismaModifier;
    }
    
    public function getAbilities($characterUsed)
    {
        $abilities = array("strength" => 0, "dexterity" => 0, "constitution" => 0, "intelligence" => 0, "wisdom" => 0, "charisma" => 0);
        
        for($i = 1; $i <= 6; $i++ ) {
            switch ($i) {
                case 1:
                    $strength = $this->getStrength($characterUsed);
                    $abilities["strength"] = $strength;
                    break;
                case 2:
                    $dexterity = $this->getDexterity($characterUsed);
                    $abilities["dexterity"] = $dexterity;
                    break;
                case 3:
                    $constitution = $this->getConstitution($characterUsed);
                    $abilities["constitution"] = $constitution;
                    break;
                case 4:
                    $intelligence = $this->getIntelligence($characterUsed);
                    $abilities["intelligence"] = $intelligence;
                    break;
                case 5:
                    $wisdom = $this->getWisdom($characterUsed);
                    $abilities["wisdom"] = $wisdom;
                    break;
                case 6:
                    $charisma = $this->getCharisma($characterUsed);
                    $abilities["charisma"] = $charisma;
                    break;
            }
        }
        
        return $abilities;
    }

    public function cloneCharacterUsedAbility($characterUsedAbility, $characterUsed)
    {
        $newCharacterUsedAbility = clone $characterUsedAbility;
        $newCharacterUsedAbility->setCharacterUsed($characterUsed);
        $newCharacterUsedAbility->setId(null);

        $this->em->persist($newCharacterUsedAbility);
        $this->em->flush();

        return $newCharacterUsedAbility;
    }
}
