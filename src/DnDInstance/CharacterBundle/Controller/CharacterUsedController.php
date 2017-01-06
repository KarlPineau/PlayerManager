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

class CharacterUsedController extends Controller
{
    public function indexAction()
    {
        $repositoryCharactersUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:index.html.twig', array(
            'listCharactersUsed' => $repositoryCharactersUsed->findAll(),
        ));
    }
    
    public function registerAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        // -- Création du personnage :
        $characterUsed = new CharacterUsed;

        // -- Gestion de la richesse du personnage :
        $characterWealth = new CharacterWealth;
        $characterWealth->setCreateUser($this->getUser()); $characterWealth->setPo(0); $characterWealth->setPa(0); $characterWealth->setPc(0);
        $characterWealth->setCharacterUsedWealth($characterUsed);

        // -- Info de base
        $characterUsed->setCreateUser($this->getUser());
        $characterUsed->setHpCurrent(0); $characterUsed->setHpMax(0); $characterUsed->addWealth($characterWealth);

        // -- Création des XpPoints :
        $xpPoints = new XpPoints;
        $xpPoints->setCreateUser($this->getUser());
        $xpPoints->setCharacterUsedDnDXpPoints($characterUsed);
        $xpPoints->setIncrease(0);
        $characterUsed->addXpPoint($xpPoints);
        
        // -- Gestion des Caractéristiques du personnage :
        $repositoryAbility = $em->getRepository('DnDRulesAbilityBundle:Ability');
        $strength = new CharacterAbility;        $strength->setCreateUser($this->getUser());       $strength->setAbility($repositoryAbility->findOneByName('Force'));              $strength->setValue(0);     $strength->setCharacterUsedDnDAbilities($characterUsed);
        $dexterity = new CharacterAbility;       $dexterity->setCreateUser($this->getUser());      $dexterity->setAbility($repositoryAbility->findOneByName('Dextérité'));         $dexterity->setValue(0);    $dexterity->setCharacterUsedDnDAbilities($characterUsed);
        $constitution = new CharacterAbility;    $constitution->setCreateUser($this->getUser());   $constitution->setAbility($repositoryAbility->findOneByName('Constitution'));   $constitution->setValue(0); $constitution->setCharacterUsedDnDAbilities($characterUsed);
        $intelligence = new CharacterAbility;    $intelligence->setCreateUser($this->getUser());   $intelligence->setAbility($repositoryAbility->findOneByName('Intelligence'));   $intelligence->setValue(0); $intelligence->setCharacterUsedDnDAbilities($characterUsed);
        $wisdom = new CharacterAbility;          $wisdom->setCreateUser($this->getUser());         $wisdom->setAbility($repositoryAbility->findOneByName('Sagesse'));              $wisdom->setValue(0);       $wisdom->setCharacterUsedDnDAbilities($characterUsed);
        $charisma = new CharacterAbility;        $charisma->setCreateUser($this->getUser());       $charisma->setAbility($repositoryAbility->findOneByName('Charisme'));           $charisma->setValue(0);     $charisma->setCharacterUsedDnDAbilities($characterUsed);

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
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($characterUsed->getClassDnDInstances() as $classDnDInstance) {
                $classDnDInstance->setCreateUser($this->getUser());
                $classDnDInstance->setCharacterUsedDnDInstance($characterUsed);
                $em->persist($classDnDInstance);
            }
            // -- On crée un CharacterSkill pour chaque Skill
            foreach ($em->getRepository('DnDRulesSkillBundle:Skill')->findAll() as $skill) {
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
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        if(isset($_GET['context']) and !empty($_GET['context'])) {$context = $_GET['context'];} elseif(isset($_POST['context']) and !empty($_POST['context'])) {$context = $_POST['context'];} else {$context = 'block';}
        if(isset($_GET['profile']) and !empty($_GET['profile'])) {$profile = $_GET['profile'];} elseif(isset($_POST['profile']) and !empty($_POST['profile'])) {$profile = $_POST['profile'];} else {$profile = 'full';}
        if(isset($_GET['newLevel']) and !empty($_GET['newLevel'])) {$newLevel = $_GET['newLevel'];} elseif(isset($_POST['newLevel']) and !empty($_POST['newLevel'])) {$newLevel = $_POST['newLevel'];} else {$newLevel = false;}

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
                                'newLevel' => $newLevel,
                                'context' => $context
                            ));
    }
    
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('CharacterUsed : [slug='.$slug.'] undefined.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('CharacterUsed : [slug='.$slug.'] undefined.');}

        // -- Calcul des droits de l'utilisateur
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $role_user = 'admin';
        } else {
            $role_user = 'public';
        }

        $form = $this->createForm(new CharacterUsedEditType, $characterUsed, array(
                'attr' => array('user_id' => $this->getUser()->getId(), 'role' => $role_user))
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->setUpdateUser($this->getUser());
            $em->persist($characterUsed);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
            return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug()));
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

    public function cloneAction($slug)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        $newCharacterUsed = $this->container->get('dndinstance_character.characterusedaction')->cloneCharacterUsed($characterUsed);

        $this->get('session')->getFlashBag()->add('notice', 'Le personnage a bien été supprimé.' );
        return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $newCharacterUsed->getSlug()));
    }
}
