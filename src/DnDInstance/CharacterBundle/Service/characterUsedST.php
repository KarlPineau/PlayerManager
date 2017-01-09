<?php

namespace DnDInstance\CharacterBundle\Service;

use DnDRules\RaceBundle\Service\race;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedST
{
    protected $em;
    protected $security;
    protected $characterusedability;
    protected $race;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, CharacterUsedAbility $characterusedability, race $race)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->characterusedability = $characterusedability;
        $this->race = $race;
    }
    
    public function getFortitude($characterUsed) { 
        //Retourne le JdS Réflex du personnage 
        //Mod. de Caractéristique à prendre en compte : Dextérité
        $modBases = array();
        
        $classDnDInstances = $characterUsed->getClassDnDInstances();
        foreach ($classDnDInstances as $classDnDInstance) {
            $classDnD = $classDnDInstance->getClassDnD();
            $level = $classDnDInstance->getLevel();
            
            $repositoryClassDnDLevel = $this->em->getRepository('DnDRulesClassDnDBundle:ClassDnDLevel');
            $classDnDLevel = $repositoryClassDnDLevel->findOneBy(array('classDnD' => $classDnD, 'level' => $level));
            $repositoryClassST = $this->em->getRepository('DnDRulesClassDnDBundle:ClassST');
            $classST = $repositoryClassST->findOneBy(array('classDnDLevelST' => $classDnDLevel));
            array_push($modBases, $classST->getFortitude());
        }
        arsort($modBases); //Tri par ordre décroissant
        
        $modBase = $modBases[0];
        $modAbility = $this->characterusedability->getDexterityModifier($characterUsed);
        $modMagic = 0;
        $modDivers = 0;
        $modTempo = 0;

        if($this->race->getST($characterUsed->getRace()) != null) {
            $modDivers += $this->race->getST($characterUsed->getRace())->getFortitude();
        }

        $fortitude = $modBase + $modAbility + $modMagic + $modDivers + $modTempo;
        return $fortitude;
    }

    public function getReflex($characterUsed) { 
        //Retourne le JdS Vigueur du personnage
        //Mod. de Caractéristique à prendre en compte : Constitution
        $modBases = array();
        
        $classDnDInstances = $characterUsed->getClassDnDInstances();
        foreach ($classDnDInstances as $classDnDInstance) {
            $classDnD = $classDnDInstance->getClassDnD();
            $level = $classDnDInstance->getLevel();
            
            $repositoryClassDnDLevel = $this->em->getRepository('DnDRulesClassDnDBundle:ClassDnDLevel');
            $classDnDLevel = $repositoryClassDnDLevel->findOneBy(array('classDnD' => $classDnD, 'level' => $level));
            $repositoryClassST = $this->em->getRepository('DnDRulesClassDnDBundle:ClassST');
            $classST = $repositoryClassST->findOneBy(array('classDnDLevelST' => $classDnDLevel));
            array_push($modBases, $classST->getReflex());
        }
        arsort($modBases); //Tri par ordre décroissant
        
        $modBase = $modBases[0];
        $modAbility = $this->characterusedability->getConstitutionModifier($characterUsed);
        $modMagic = 0;
        $modDivers = 0;
        $modTempo = 0;

        if($this->race->getST($characterUsed->getRace()) != null) {
            $modDivers += $this->race->getST($characterUsed->getRace())->getReflex();
        }

        $reflex = $modBase + $modAbility + $modMagic + $modDivers + $modTempo;
        return $reflex;
    }

    public function getWill($characterUsed) { 
        //Retourne le JdS Volonté du personnage
        //Mod. de Caractéristique à prendre en compte : Sagesse
        $modBases = array();
        
        $classDnDInstances = $characterUsed->getClassDnDInstances();
        foreach ($classDnDInstances as $classDnDInstance) {
            $classDnD = $classDnDInstance->getClassDnD();
            $level = $classDnDInstance->getLevel();
            
            $repositoryClassDnDLevel = $this->em->getRepository('DnDRulesClassDnDBundle:ClassDnDLevel');
            $classDnDLevel = $repositoryClassDnDLevel->findOneBy(array('classDnD' => $classDnD, 'level' => $level));
            $repositoryClassST = $this->em->getRepository('DnDRulesClassDnDBundle:ClassST');
            $classST = $repositoryClassST->findOneBy(array('classDnDLevelST' => $classDnDLevel));
            array_push($modBases, $classST->getWill());
        }
        arsort($modBases); //Tri par ordre décroissant
        
        $modBase = $modBases[0];
        $modAbility = $this->characterusedability->getWisdomModifier($characterUsed);
        $modMagic = 0;
        $modDivers = 0;
        $modTempo = 0;

        if($this->race->getST($characterUsed->getRace()) != null) {
            $modDivers += $this->race->getST($characterUsed->getRace())->getWill();
        }

        $will = $modBase + $modAbility + $modMagic + $modDivers + $modTempo;
        return $will;
    }
}
