<?php

namespace DnDInstance\MonsterBundle\Controller;

use DnDInstance\MonsterBundle\Form\InstanceMonsterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\MonsterBundle\Form\MonsterInstanceEditType;
use Symfony\Component\HttpFoundation\Request;

class MonsterController extends Controller
{
    public function instanceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneById($id);
        if($game === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Game [id='.$id.'] undefined.');}

        $form = $this->createForm(new InstanceMonsterType());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->container->get('dndinstance_monster.monster')->instanceMonster(
                $form->get('monster')->getData(),
                [
                    'weak' => $form->get('weakNumber')->getData(),
                    'strong' => $form->get('strongNumber')->getData(),
                    'default' => $form->get('defaultNumber')->getData(),
                    'random' => $form->get('randomNumber')->getData(),
                ],
                $game);
        
            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les monstres ont bien été générés.');
            return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
        }
        return $this->render('DnDInstanceMonsterBundle:Monster:instance_content.html.twig', array(
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
    
    public function listForGameAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneById($id);
        if($game === null) {throw $this->createNotFoundException('Game [id='.$id.'] undefined.');}
        
        return $this->render('DnDInstanceMonsterBundle:Monster:listForGame.html.twig', array(
            'monsterInstances' => $em->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findByGame($game),
        ));
    }
    
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monsterInstance = $em->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findOneById($id);
        if($monsterInstance === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterInstance [id='.$id.'] undefined.');}
        
        $form = $this->createForm(new MonsterInstanceEditType, $monsterInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monsterInstance->setUpdateUser($this->getUser());
            $em->persist($monsterInstance);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre a bien été édité.' );
            return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $monsterInstance->getGame()->getSlug())));
        }
        return $this->render('DnDInstanceMonsterBundle:Monster:Edit/edit.html.twig', array(
                                'monsterInstance' => $monsterInstance,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($id)
    {
        $monsterInstance = $this->getDoctrine()->getManager()->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findOneById($id);
        if($monsterInstance === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterInstance [id='.$id.'] undefined.');}
        
        $slugGame = $monsterInstance->getGame()->getSlug();
        
        $serviceMonsterInstanceAction = $this->container->get('dndinstance_monster.monster');
        $serviceMonsterInstanceAction->deleteMonsterInstance($monsterInstance);
             
        $this->get('session')->getFlashBag()->add('notice', 'Le monstre a bien été supprimé.' );
        return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $slugGame)));
    }
}
