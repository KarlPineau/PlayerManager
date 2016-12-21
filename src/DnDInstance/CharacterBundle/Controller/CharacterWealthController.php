<?php

namespace DnDInstance\CharacterBundle\Controller;

use DnDInstance\CharacterBundle\Form\CharacterWealthType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CharacterWealthController extends Controller
{
    public function editWealthAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        $form = $this->createForm(new CharacterWealthType(), $characterUsed->getWealth());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->getWealth()->setPo(intval($form->get('poAdd')->getData())+$characterUsed->getWealth()->getPo());
            $characterUsed->getWealth()->setPa(intval($form->get('paAdd')->getData())+$characterUsed->getWealth()->getPa());
            $characterUsed->getWealth()->setPc(intval($form->get('pcAdd')->getData())+$characterUsed->getWealth()->getPc());
            $em->persist($characterUsed);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le montant de votre fortune a bien été édité.' );
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:wealth/edit_wealth.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
