<?php

namespace DnDInstance\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\MonsterBundle\Form\GenerateMonsterType;
use DnDInstance\MonsterBundle\Form\MonsterInstanceEditType;

class MonsterController extends Controller
{
    public function generateAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if ($game === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}

        $form = $this->createForm(new GenerateMonsterType);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $serviceMonsterInstance = $this->container->get('dndinstance_monster.monster');
                    $serviceMonsterInstance->generateMonster($form->get('monster')->getData(), $form->get('number')->getData(), $game);
        
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les monstres ont bien été créés.');
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
                }
            }
        return $this->render('DnDInstanceMonsterBundle:Monster:generate_content.html.twig', array(
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
    
    public function listForGameAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        $monsterInstances = $em->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findByGame($game);
        
        return $this->render('DnDInstanceMonsterBundle:Monster:listForGame.html.twig', array(
                                'monsterInstances' => $monsterInstances,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $monsterInstance = $em->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findOneBySlug($slug);
        if($monsterInstance === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Instance du monstre : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new MonsterInstanceEditType, $monsterInstance);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monsterInstance->setUpdateUser($this->getUser());
                    $em->persist($monsterInstance);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre a bien été édité.' );
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $monsterInstance->getGame()->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceMonsterBundle:Monster:Edit/edit.html.twig', array(
                                'monsterInstance' => $monsterInstance,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $monsterInstance = $this->getDoctrine()->getManager()->getRepository('DnDInstanceMonsterBundle:MonsterInstance')->findOneBySlug($slug);
        if($monsterInstance === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Instance du monstre [slug='.$slug.'] inexistante.');}
        
        $slugGame = $monsterInstance->getGame()->getSlug();
        
        $serviceMonsterInstanceAction = $this->container->get('dndinstance_monster.monster');
        $serviceMonsterInstanceAction->deleteMonsterInstance($monsterInstance);
             
        $this->get('session')->getFlashBag()->add('notice', 'Le monstre a bien été supprimé.' );
        return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $slugGame)));
    }
}
