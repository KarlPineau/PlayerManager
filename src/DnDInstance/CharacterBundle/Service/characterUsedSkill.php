<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedSkill
{
    protected $em;
    protected $security;
    protected $characterusedability;
    protected $characterusedclassdnd;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, CharacterUsedAbility $characterusedability, characterUsedClassDnD $characterUsedClassDnD)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->characterusedability = $characterusedability;
        $this->characterusedclassdnd = $characterUsedClassDnD;
    }
    
    public function getCharacterSkillModifier($characterSkill, $detail=false) {
        // Retourne le modificateur de compétence
        if ($characterSkill === null) {
          throw $this->createNotFoundException('Liaison de Compétence inexistante.');
        }
        
        // -- Obtention du Modificateur de Caractéristique pour la caractéristique valable sur la compétence en cours
        $abilitySkill = $characterSkill->getSkill()->getAbility();
        $abilityCharacter = $this->characterusedability->getAbility($characterSkill->getCharacterUsedSkills(), $abilitySkill);
        $abilityCharacterModifier = $this->characterusedability->getAbilityModifier($abilityCharacter);
        
        // -- Obtention du degré de maitrise de la compétence en cours :
        $skillRanks = $characterSkill->getRanks();

        // -- Obtention du modificateur de race :
        $skillRaceAdditional = 0;
        if($this->em->getRepository('DnDRulesRaceBundle:RaceSkill')->findOneBy(array('race' =>  $characterSkill->getCharacterUsedSkills()->getRace(), 'skill' => $characterSkill->getSkill())) != null) {
            $skillRaceAdditional += $this->em->getRepository('DnDRulesRaceBundle:RaceSkill')->findOneBy(array('race' =>  $characterSkill->getCharacterUsedSkills()->getRace(), 'skill' => $characterSkill->getSkill()))->getValue();
        }
        
        // -- Addition finale :
        if($detail == false) {$skillModifier = $skillRanks + $abilityCharacterModifier + $skillRaceAdditional;}
        elseif($detail == true) {$skillModifier = "<abbr title=\"Degré de Maitrise\">" . $skillRanks . "</abbr> + <abbr title=\"Mod. de Caractéristique (". $abilitySkill->getName() .")\">" . $abilityCharacterModifier . "</abbr> + <abbr title=\"Autres modific. (race ...)\">" . $skillRaceAdditional . "</abbr>";}
        return $skillModifier;
    }
    
    public function getMaxRanksForSkill($characterSkill) {
        // Retourne le degré de maitrise maximum qu'un joueur peut attribuer à son personnage pour une compétence
        if ($characterSkill === null) {
          throw $this->createNotFoundException('Liaison de Compétence inexistante.');
        }
        
        /*
         * Calcul : -> On regarde si la compétence est une compétence de classe pour une des classes du perso
         * Si oui : retourne le nb de pt pour compétence de classe pour ce niveau, si non le nb de points pour compétence hors classe
         */
        
        $skill = $characterSkill->getSkill();
        $match = false;
        
        $classDnDInstances = $characterSkill->getCharacterUsedSkills()->getClassDnDInstances();
        foreach ($classDnDInstances as $classDnDInstance) {
            $skillsClass = $classDnDInstance->getClassDnD()->getSkills();
            $matchClassDnDInstance = $classDnDInstance;
            foreach($skillsClass as $skillClass) {
                if($skillClass == $skill) 
                {
                    $match = true; 
                    break;
                }
            }
        }

        $maxRanks = null;
        if($match == true) {$maxRanks = $matchClassDnDInstance->getLevel()->getClassSkillModifier();}
        elseif($match == false) {$maxRanks = $matchClassDnDInstance->getLevel()->getofClassSkillModifier();}
        
        return $maxRanks;
    }

    public function getCharacterSkillRank($characterSkill) {
        // Retourne le degré de maitrise pour une compétence
        if ($characterSkill === null) {throw $this->createNotFoundException('Liaison de Compétence inexistante.');}

        return $characterSkill->getRanks();
    }

    public function getTotalCountPointCurrent($characterUsed) {
        $count = 0;

        foreach($this->em->getRepository('DnDInstanceCharacterBundle:CharacterSkill')->findBy(array('characterUsedSkills' => $characterUsed)) as $characterSkill) {
            $count += $characterSkill->getRanks();
        }

        return $count;
    }

    public function getTotalCountPointMax($characterUsed) {
        $modInt = $this->characterusedability->getIntelligenceModifier($characterUsed);
        $pointForLevel1 = $this->characterusedclassdnd->getMainClassDnD($characterUsed)->getPointsSkillFirstLevel();
        $pointByLevel = $this->characterusedclassdnd->getMainClassDnD($characterUsed)->getPointsSkillByLevel();
        $level = $this->characterusedclassdnd->getMainLevel($characterUsed);

        $maxPoints = (($pointForLevel1+$modInt)*4)+(($pointByLevel+$modInt)*($level-1));

        // Ajout des points attribués par la race
        for($levelI = 0; $levelI <= $level; $levelI++) {
            if($this->em->getRepository('DnDRulesRaceBundle:RaceLevel')->findOneBy(array('race' => $characterUsed->getRace(), 'level' => $levelI)) != null) {
                $maxPoints += $this->em->getRepository('DnDRulesRaceBundle:RaceLevel')->findOneBy(array('race' => $characterUsed->getRace(), 'level' => $levelI))->getAdditionalSkillPoints();
            }
        }

        return $maxPoints;
    }

    public function cloneCharacterUsedSkill($characterUsedSkill, $characterUsed)
    {
        $newCharacterUsedSkill = clone $characterUsedSkill;
        $newCharacterUsedSkill->setCharacterUsedSkills($characterUsed);
        $newCharacterUsedSkill->setId(null);

        $this->em->persist($newCharacterUsedSkill);
        $this->em->flush();

        return $newCharacterUsedSkill;
    }
}
