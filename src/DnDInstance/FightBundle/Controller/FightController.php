<?php

namespace DnDInstance\FightBundle\Controller;

use DnDInstance\FightBundle\Form\GenerateFightType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FightController extends Controller
{
    public function generateAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        if ($game === null) {throw $this->createNotFoundException('Game : [slug='.$slug.'] inexistant.');}

        $form = $this->createForm(new GenerateFightType());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('dndinstance_fight.fight')->generateFight($form->get('monsterInstances')->getData(), $form->get('characters')->getData(), $game);

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le combat est prêt.');
            return $this->redirectToRoute('game_game_game_view', array('slug' => $game->getSlug()));
        }
        return $this->render('DnDInstanceFightBundle:Fight:generate_content.html.twig', array(
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
    
    public function listForGameAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($slug);
        $fights = $em->getRepository('DnDInstanceFightBundle:Fight')->findByGame($game);
        
        return $this->render('DnDInstanceFightBundle:Fight:listForGame.html.twig', array(
                                'fights' => $fights,
                                'game' => $game
                            ));
    }
    
    public function deleteAction($id)
    {
        $fight = $this->getDoctrine()->getManager()->getRepository('DnDInstanceFightBundle:Fight')->findOneById($id);
        if ($fight === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Instance du combat [id='.$id.'] inexistante.');}
        $slugGame = $fight->getGame()->getSlug();
        $this->container->get('dndinstance_fight.fightaction')->deleteFight($fight);
             
        $this->get('session')->getFlashBag()->add('notice', 'Le combat a bien été supprimé.' );
        return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $slugGame)));
    }
}
