<?php

namespace Game\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Game\GameBundle\Entity\Game;
use Game\GameBundle\Form\GameRegisterType;
use Game\GameBundle\Form\GameEditType;

class GameController extends Controller
{
    public function indexAction()
    {
        $listGames = $this->getDoctrine()->getManager()->getRepository('GameGameBundle:Game')->findAll();
        return $this->render('GameGameBundle:Game:index.html.twig', array(
            'listGames' => $listGames,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $game = new Game;
        $game->setCreateUser($this->getUser());
        
        $form = $this->createForm(new GameRegisterType, $game);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($game);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la partie a bien été créée.' );
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
                }
            }
        return $this->render('GameGameBundle:Game:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if ($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}
        
        return $this->render('GameGameBundle:Game:View/view.html.twig', array(
                                'game' => $game,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if ($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new GameEditType, $game);
        $game->setUpdateUser($this->getUser());
        
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($game);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre partie a bien été éditée.' );
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
                }
            }
        
        return $this->render('GameGameBundle:Game:Edit/edit.html.twig', array(
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if ($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}
        
        $gameAction = $this->container->get('game_game.gameaction');
        $gameAction->deleteGame($game);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre partie a bien été supprimée.' );
        return $this->redirectToRoute('game_game_game_home');
    }
}
