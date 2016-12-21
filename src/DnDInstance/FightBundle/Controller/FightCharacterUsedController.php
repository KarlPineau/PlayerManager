<?php

namespace DnDInstance\FightBundle\Controller;

use DnDInstance\FightBundle\Form\FightCharacterUsedEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FightCharacterUsedController extends Controller
{
    public function editAction($id, $game_slug)
    {
        $em = $this->getDoctrine()->getManager();
        $fightCharacterUsed = $em->getRepository('DnDInstanceFightBundle:FightCharacterUsed')->findOneById($id);
        if($fightCharacterUsed === null) {throw $this->createNotFoundException('Instance du fightcharacter : [slug='.$id.'] inexistante.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBySlug($game_slug);
        if($game === null) {throw $this->createNotFoundException('Game : [slug='.$game_slug.'] inexistant.');}
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}

        $form = $this->createForm(new FightCharacterUsedEditType(), $fightCharacterUsed);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $fightCharacterUsed->setUpdateUser($this->getUser());
                    $em->persist($fightCharacterUsed);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre instance a bien été éditée.' );
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game_slug)));
                }
            }
        
        return $this->render('DnDInstanceFightBundle:FightCharacterUsed:edit.html.twig', array(
                                'fightCharacterUsed' => $fightCharacterUsed,
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
}
