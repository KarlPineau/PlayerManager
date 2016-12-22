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

class CharacterUsedController extends Controller
{
    public function indexAction()
    {
        $repositoryCharactersUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:index.html.twig', array(
            'listCharactersUsed' => $repositoryCharactersUsed->findAll(),
        ));
    }
    
    public function registerAction()
    {   
        $em = $this->getDoctrine()->getManager();
        // -- Gestion de la richesse du personnage :
        $characterWealth = new CharacterWealth;
        $characterWealth->setCreateUser($this->getUser()); $characterWealth->setPo(0); $characterWealth->setPa(0); $characterWealth->setPc(0);
        
        // -- Création du personnage :
        $characterUsed = new CharacterUsed;
        $characterUsed->setCreateUser($this->getUser());
        $characterUsed->setHpCurrent(0); $characterUsed->setHpMax(0); $characterUsed->setWealth($characterWealth);
        
        // -- Création des XpPoints :
        $xpPoints = new XpPoints;
        $xpPoints->setCreateUser($this->getUser());
        $xpPoints->setCharacterUsed($characterUsed);
        $xpPoints->setIncrease(0);
        
        // -- Gestion des Caractéristiques du personnage :
        $repositoryAbility = $em->getRepository('DnDRulesAbilityBundle:Ability');
        $strength = new CharacterAbility;        $strength->setCreateUser($this->getUser());       $strength->setAbility($repositoryAbility->findOneByName('Force'));              $strength->setValue(0);     $strength->setCharacterUsed($characterUsed);
        $dexterity = new CharacterAbility;       $dexterity->setCreateUser($this->getUser());      $dexterity->setAbility($repositoryAbility->findOneByName('Dextérité'));         $dexterity->setValue(0);    $dexterity->setCharacterUsed($characterUsed);
        $constitution = new CharacterAbility;    $constitution->setCreateUser($this->getUser());   $constitution->setAbility($repositoryAbility->findOneByName('Constitution'));   $constitution->setValue(0); $constitution->setCharacterUsed($characterUsed);
        $intelligence = new CharacterAbility;    $intelligence->setCreateUser($this->getUser());   $intelligence->setAbility($repositoryAbility->findOneByName('Intelligence'));   $intelligence->setValue(0); $intelligence->setCharacterUsed($characterUsed);
        $wisdom = new CharacterAbility;          $wisdom->setCreateUser($this->getUser());         $wisdom->setAbility($repositoryAbility->findOneByName('Sagesse'));              $wisdom->setValue(0);       $wisdom->setCharacterUsed($characterUsed);
        $charisma = new CharacterAbility;        $charisma->setCreateUser($this->getUser());       $charisma->setAbility($repositoryAbility->findOneByName('Charisme'));           $charisma->setValue(0);     $charisma->setCharacterUsed($characterUsed);

        // -- Calcul des droits de l'utilisateur
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $role_user = 'admin';
        } else {
            $role_user = 'public';
        }

        // -- Création du formulaire :
        $form = $this->createForm(new CharacterUsedRegisterType, $characterUsed, array(
            'attr' => array('user_id' => $this->getUser()->getId(), 'role' => $role_user))
        );
 
        // -- Validation du formulaire :
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    // -- Gestion de la classe
                    $classDnDInstances = $characterUsed->getClassDnDInstances();
                    foreach ($classDnDInstances as $classDnDInstance) {
                        $classDnDInstance->setCreateUser($this->getUser());
                        $classDnDInstance->setCharacterUsedDnDInstance($characterUsed);
                        $em->persist($classDnDInstance);
                    }
                    // -- On crée un CharacterSkill pour chaque Skill
                    $repositorySkill = $em->getRepository('DnDRulesSkillBundle:Skill');
                    $skills = $repositorySkill->findAll();
                    foreach ($skills as $skill) {
                        $characterSkill = new CharacterSkill;
                        $characterSkill->setCreateUser($this->getUser());
                        $characterSkill->setCharacterUsedSkills($characterUsed);
                        $characterSkill->setSkill($skill);
                        $characterSkill->setRanks(0);
                        $em->persist($characterSkill);
                    }
                    // -- Autres paramètres :
                    $em->persist($characterUsed);
                    $em->persist($characterWealth);
                    $em->persist($xpPoints);
                    $em->persist($strength); $em->persist($dexterity); $em->persist($constitution); $em->persist($intelligence); $em->persist($wisdom); $em->persist($charisma);
                    
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été créé.' );
                    //Renvoie vers la page de gestion des Caractéristiques :
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_edit_abilities', array('slug' => $characterUsed->getSlug(), 'context' => 'register')));
                }
            }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        if(isset($_GET['context']) and !empty($_GET['context'])) {$context = $_GET['context'];} else {$context = 'block';}
        if(isset($_GET['profile']) and !empty($_GET['profile'])) {$profile = $_GET['profile'];} else {$profile = 'full';}
        if(isset($_GET['newLevel']) and !empty($_GET['newLevel'])) {$newLevel = $_GET['newLevel'];} else {$newLevel = false;}

        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        $sortsByClasses = array();
        foreach ($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $sortsByClass = array();
            $sortsByLevel = $this->get('dndrules_classdnd.classdndaction')->getSorts($classDnDInstance->getClassDnD());
            array_push($sortsByClass, $classDnDInstance->getClassDnD());
            array_push($sortsByClass, $sortsByLevel);
            array_push($sortsByClasses, $sortsByClass);
        }

        if($context == 'inline') {$fileRender = 'DnDInstanceCharacterBundle:CharacterUsed:view/view_content.html.twig';}
        else {$fileRender = 'DnDInstanceCharacterBundle:CharacterUsed:view.html.twig';}
        
        return $this->render($fileRender, array(
                                'characterUsed' => $characterUsed,
                                'sortsByClasses' => $sortsByClasses,
                                'profile' => $profile,
                                'newLevel' => $newLevel
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        // -- Calcul des droits de l'utilisateur
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $role_user = 'admin';
        } else {
            $role_user = 'public';
        }

        $form = $this->createForm(new CharacterUsedEditType, $characterUsed, array(
                'attr' => array('user_id' => $this->getUser()->getId(), 'role' => $role_user))
        );
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $characterUsed->setUpdateUser($this->getUser());
                    $em->persist($characterUsed);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                    return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug()));
                }
            }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Edit/edit.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        $serviceCharacterUsedAction = $this->container->get('dndinstance_character.characterusedaction');
        $serviceCharacterUsedAction->deleteCharacterUsed($characterUsed);
             
        $this->get('session')->getFlashBag()->add('notice', 'Le personnage a bien été supprimé.' );
        return $this->redirectToRoute('dndinstance_characterused_characterused_home');
    }

    public function upgradeLevelAction($slug)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        if($this->get('dndinstance_character.characteruseddnd')->isNewLevel($characterUsed)) {
            $level = $this->get('dndinstance_character.characteruseddnd')->setUpgradeLevel($characterUsed);
            $this->get('session')->getFlashBag()->add('notice', 'Vous gagnez un niveau ! Vous êtes niveau '.$level->getLevel() );
        }

        return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug(), 'newLevel' => true));
    }
}
