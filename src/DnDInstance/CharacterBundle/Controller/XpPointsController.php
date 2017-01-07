<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\XpPointsType;
use Symfony\Component\HttpFoundation\Request;

class XpPointsController extends Controller
{
    public function editXpPointsAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        $xpPoints = $em->getRepository('DnDInstanceCharacterBundle:XpPoints')->findOneBy(array('characterUsedDnDXpPoints' => $characterUsed));
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined');}

        $form = $this->createForm(new XpPointsType, $xpPoints);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $xpPoints->setIncrease(intval($form->get('increaseAdd')->getData())+$xpPoints->getIncrease());
            $em->persist($xpPoints);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, vos XP ont bien été édités.' );
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:XpPoints/edit_xpPoints.html.twig', array(
                                'xpPoints' => $xpPoints,
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
