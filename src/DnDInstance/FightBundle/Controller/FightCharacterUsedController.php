<?php

namespace DnDInstance\FightBundle\Controller;

use DnDInstance\FightBundle\Form\FightCharacterUsedEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FightCharacterUsedController extends Controller
{
    public function editAction($fightCharacterUsedInstance_id, $game_id)
    {
        $em = $this->getDoctrine()->getManager();
        $fightCharacterUsed = $em->getRepository('DnDInstanceFightBundle:FightCharacterUsed')->findOneById($fightCharacterUsedInstance_id);
        if($fightCharacterUsed === null) {throw $this->createNotFoundException('FightCharacterUsedInstance [id='.$fightCharacterUsedInstance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneById($game_id);
        if($game === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Game [id='.$game_id.'] undefined.');}

        $form = $this->createForm(new FightCharacterUsedEditType(), $fightCharacterUsed);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $fightCharacterUsed->setUpdateUser($this->getUser());
                    $em->persist($fightCharacterUsed);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre instance a bien été éditée.' );
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceFightBundle:FightCharacterUsed:Edit/edit.html.twig', array(
                                'fightCharacterUsed' => $fightCharacterUsed,
                                'game' => $game,
                                'form' => $form->createView(),
                            ));
    }
}
