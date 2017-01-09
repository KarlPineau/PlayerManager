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
    
    public function viewAction($slug, $context, $profile, $newLevel)
    {
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

        if($context == 'inline') {$fileRender = 'DnDInstanceCharacterBundle:CharacterUsed:View/view_content.html.twig';}
        else {$fileRender = 'DnDInstanceCharacterBundle:CharacterUsed:view.html.twig';}
        
        return $this->render($fileRender, array(
                                'characterUsed' => $characterUsed,
                                'sortsByClasses' => $sortsByClasses,
                                'profile' => $profile,
                                'newLevel' => $newLevel,
                                'context' => $context
                            ));
    }
    
    public function editAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        // -- Calcul des droits de l'utilisateur
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) { $role_user = 'admin';}
        else {$role_user = 'public';}


        $form = $this->createForm(new CharacterUsedEditType, $characterUsed,
            array('attr' => array(
                'user_id' => $this->getUser()->getId(),
                'role' => $role_user,
                'levelMin' => $characterUsed->getGame()->getLvlMin(),
                'levelMax' => $characterUsed->getGame()->getLvlMax(),
                'openClasses' => $characterUsed->getGame()->getOpenClasses(),
                'openRaces' => $characterUsed->getGame()->getOpenRaces(),
            ))
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($characterUsed->getClassDnDInstances() as $classDnDInstance) {
                $classDnDInstance->setCreateUser($this->getUser());
                $classDnDInstance->setCharacterUsedDnDInstance($characterUsed);
                $em->persist($classDnDInstance);
            }

            $characterUsed->setUpdateUser($this->getUser());
            $em->persist($characterUsed);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug()));
            } elseif($context == 'register') {
                return $this->redirectToRoute('dndinstance_characterused_characterused_edit_abilities', array('id' => $characterUsed->getId(), 'context' => 'register'));
            }
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Edit/edit.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }
    
    public function deleteAction($id)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $serviceCharacterUsedAction = $this->container->get('dndinstance_character.characterusedaction');
        $serviceCharacterUsedAction->deleteCharacterUsed($characterUsed);
             
        $this->get('session')->getFlashBag()->add('notice', 'Le personnage a bien été supprimé.' );
        return $this->redirectToRoute('dndinstance_characterused_characterused_home');
    }

    public function upgradeLevelAction($id)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        if($this->get('dndinstance_character.characteruseddnd')->isNewLevel($characterUsed)) {
            $level = $this->get('dndinstance_character.characteruseddnd')->setUpgradeLevel($characterUsed);
            $this->get('session')->getFlashBag()->add('notice', 'Vous gagnez un niveau ! Vous êtes niveau '.$level->getLevel() );
        }

        if($this->get('dndinstance_character.characterusedclassdnd')->getMainLevelInstance($characterUsed)->getAbilityUp() == true) {
            return $this->redirectToRoute('dndinstance_characterused_characterused_edit_abilities', array('id' => $characterUsed->getId(), 'context' => 'levelUp'));
        } else {
            return $this->redirectToRoute('dndinstance_characterused_characterused_edit_skills', array('id' => $characterUsed->getId(), 'context' => 'levelUp'));
        }
    }

    public function cloneAction($id)
    {
        $characterUsed = $this->getDoctrine()->getManager()->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $newCharacterUsed = $this->container->get('dndinstance_character.characterusedaction')->cloneCharacterUsed($characterUsed);

        $this->get('session')->getFlashBag()->add('notice', 'Le personnage a bien été supprimé.' );
        return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $newCharacterUsed->getSlug()));
    }
}
