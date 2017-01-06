<?php

namespace Game\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Game\GameBundle\Entity\Game;
use Game\GameBundle\Form\GameRegisterType;
use Game\GameBundle\Form\GameEditType;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    public function indexAction()
    {
        $listGames = $this->getDoctrine()->getManager()->getRepository('GameGameBundle:Game')->findAll();
        return $this->render('GameGameBundle:Game:index.html.twig', array(
            'listGames' => $listGames,
        ));
    }
    
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $game = new Game;

        $form = $this->createForm(new GameRegisterType, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($game->getCharacters() as $character) {
                $character->setGame($game);
                $em->persist($character);
            }

            $game->setCreateUser($this->getUser());
            $em->persist($game);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la partie a bien été créée.' );
            return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug(), 'context'=> 'inline', 'profile'=> 'short')));
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
        if($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}
        
        return $this->render('GameGameBundle:Game:view/view.html.twig', array(
                                'game' => $game,
                            ));
    }
    
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Game : [slug='.$slug.'] undefined.');}
        
        $form = $this->createForm(new GameEditType, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($game->getCharacters() as $character) {
                $character->setGame($game);
                $em->persist($character);
            }

            $game->setUpdateUser($this->getUser());
            $em->persist($game);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre partie a bien été éditée.' );
            return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug(), 'context'=> 'inline', 'profile'=> 'short')));
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
        if($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] undefined.');}
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Game : [slug='.$slug.'] undefined.');}


        $gameAction = $this->container->get('game_game.gameaction');
        $gameAction->deleteGame($game);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre partie a bien été supprimée.' );
        return $this->redirectToRoute('game_game_game_home');
    }
}
