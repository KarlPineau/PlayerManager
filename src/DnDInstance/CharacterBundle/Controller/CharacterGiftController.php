<?php

namespace DnDInstance\CharacterBundle\Controller;

use DnDInstance\CharacterBundle\Form\CharacterUsedGiftType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CharacterGiftController extends Controller
{
    public function editGiftsAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $form = $this->createForm(new CharacterUsedGiftType(), $characterUsed);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skills = $characterUsed->getSkills();
            foreach ($skills as $skill) {
                $skill->setUpdateUser($this->getUser());
                $em->persist($skill);
            }
            $em->persist($characterUsed);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
            } elseif($context == 'register') {
                return $this->redirectToRoute('dndinstance_characterused_characterused_edit_wealth', array('id' => $characterUsed->getId(), 'context' => 'register'));
            }
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Gift/edit.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }
}
