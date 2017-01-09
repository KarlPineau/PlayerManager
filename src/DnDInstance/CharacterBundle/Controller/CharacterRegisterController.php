<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Entity\CharacterUsed;
use DnDInstance\CharacterBundle\Entity\CharacterWealth;
use DnDInstance\CharacterBundle\Entity\CharacterSkill;
use DnDInstance\CharacterBundle\Entity\CharacterAbility;
use DnDInstance\CharacterBundle\Form\CharacterUsedRegisterType;
use DnDInstance\CharacterBundle\Form\CharacterUsedEditType;
use DnDInstance\CharacterBundle\Entity\XpPoints;
use Symfony\Component\HttpFoundation\Request;

class CharacterRegisterController extends Controller
{
    public function indexAction()
    {
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Register/index.html.twig');
    }

    public function registerAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        // -- Création du personnage :
        $characterUsed = new CharacterUsed;

        // -- Calcul des droits de l'utilisateur
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) { $role_user = 'admin';}
        else { $role_user = 'public'; }

        // -- Création du formulaire :
        $form = $this->createForm(new CharacterUsedRegisterType, $characterUsed, array(
            'attr' => array('user_id' => $this->getUser()->getId(), 'role' => $role_user))
        );
 
        // -- Validation du formulaire :
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // -- Gestion de la richesse du personnage :
            $characterWealth = new CharacterWealth;
            $characterWealth->setCreateUser($this->getUser()); $characterWealth->setPo(0); $characterWealth->setPa(0); $characterWealth->setPc(0);
            $characterWealth->setCharacterUsedWealth($characterUsed);
            $em->persist($characterWealth);

            // -- Info de base
            $characterUsed->setCreateUser($this->getUser());
            $characterUsed->setHpCurrent(0); $characterUsed->setHpMax(0);

            // -- Création des XpPoints :
            $xpPoints = new XpPoints;
            $xpPoints->setCreateUser($this->getUser());
            $xpPoints->setCharacterUsedDnDXpPoints($characterUsed);
            $xpPoints->setIncrease(0);
            $characterUsed->addXpPoint($xpPoints);
            $em->persist($xpPoints);


            // -- Gestion des Caractéristiques du personnage :
            $repositoryAbility = $em->getRepository('DnDRulesAbilityBundle:Ability');
            $strength = new CharacterAbility;        $strength->setCreateUser($this->getUser());       $strength->setAbility($repositoryAbility->findOneByName('Force'));              $strength->setValue(0);     $strength->setCharacterUsedDnDAbilities($characterUsed);
            $dexterity = new CharacterAbility;       $dexterity->setCreateUser($this->getUser());      $dexterity->setAbility($repositoryAbility->findOneByName('Dextérité'));         $dexterity->setValue(0);    $dexterity->setCharacterUsedDnDAbilities($characterUsed);
            $constitution = new CharacterAbility;    $constitution->setCreateUser($this->getUser());   $constitution->setAbility($repositoryAbility->findOneByName('Constitution'));   $constitution->setValue(0); $constitution->setCharacterUsedDnDAbilities($characterUsed);
            $intelligence = new CharacterAbility;    $intelligence->setCreateUser($this->getUser());   $intelligence->setAbility($repositoryAbility->findOneByName('Intelligence'));   $intelligence->setValue(0); $intelligence->setCharacterUsedDnDAbilities($characterUsed);
            $wisdom = new CharacterAbility;          $wisdom->setCreateUser($this->getUser());         $wisdom->setAbility($repositoryAbility->findOneByName('Sagesse'));              $wisdom->setValue(0);       $wisdom->setCharacterUsedDnDAbilities($characterUsed);
            $charisma = new CharacterAbility;        $charisma->setCreateUser($this->getUser());       $charisma->setAbility($repositoryAbility->findOneByName('Charisme'));           $charisma->setValue(0);     $charisma->setCharacterUsedDnDAbilities($characterUsed);
            $em->persist($strength); $em->persist($dexterity); $em->persist($constitution); $em->persist($intelligence); $em->persist($wisdom); $em->persist($charisma);

            // -- On crée un CharacterSkill pour chaque Skill
            foreach ($em->getRepository('DnDRulesSkillBundle:Skill')->findAll() as $skill) {
                $characterSkill = new CharacterSkill;
                $characterSkill->setCreateUser($this->getUser());
                $characterSkill->setCharacterUsedSkills($characterUsed);
                $characterSkill->setSkill($skill);
                $characterSkill->setRanks(0);
                $em->persist($characterSkill);
            }

            $em->persist($characterUsed);
            $em->flush();

            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_edit', array('id' => $characterUsed->getId(), 'context' => 'register')));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
}
