<?php

namespace DnDInstance\FightBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FightCharacterUsedController extends Controller
{
    public function editAction($id, $game_slug)
    {
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('DnDInstanceFightBundle:FightCharacterUsed');
 
        $fightCharacterUsed = $repository->findOneById($id);

        if ($fightCharacterUsed === null) {
          throw $this->createNotFoundException('Instance du fightcharacter : [slug='.$id.'] inexistante.');
        }
        
        $form = $this->createForm(new \DnDInstance\FightBundle\Form\FightCharacterUsedEditType, $fightCharacterUsed);
        
        $current_user = $this->getUser();
        $fightCharacterUsed->setUpdateUser($current_user);
        
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($fightCharacterUsed);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre instance a bien été éditée.' );
           
                    return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game_slug)));
                }
            }
        
        return $this->render('DnDInstanceFightBundle:FightCharacterUsed:edit.html.twig', array(
                                'fightCharacterUsed' => $fightCharacterUsed,
                                'game_slug' => $game_slug,
                                'form' => $form->createView(),
                            ));
    }
}
