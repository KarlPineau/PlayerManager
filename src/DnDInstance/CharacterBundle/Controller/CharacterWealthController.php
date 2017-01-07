<?php

namespace DnDInstance\CharacterBundle\Controller;

use DnDInstance\CharacterBundle\Form\CharacterWealthType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CharacterWealthController extends Controller
{
    public function editWealthAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $characterWealth = $em->getRepository('DnDInstanceCharacterBundle:CharacterWealth')->findOneBy(array('characterUsedWealth' => $characterUsed));
        if($characterWealth === null) {throw $this->createNotFoundException('CharacterWealth [id='.$id.'] undefined.');}

        $form = $this->createForm(new CharacterWealthType(), $characterWealth);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterWealth->setPo(intval($form->get('poAdd')->getData())+$characterWealth->getPo());
            $characterWealth->setPa(intval($form->get('paAdd')->getData())+$characterWealth->getPa());
            $characterWealth->setPc(intval($form->get('pcAdd')->getData())+$characterWealth->getPc());
            $em->persist($characterUsed);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le montant de votre fortune a bien été édité.' );
                return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
            } elseif($context == 'register') {
                return $this->redirectToRoute('dndinstance_characterused_characterused_edit_hpmax', array('id' => $characterUsed->getId(), 'context' => 'register'));
            }
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Wealth/edit_wealth.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }
}
