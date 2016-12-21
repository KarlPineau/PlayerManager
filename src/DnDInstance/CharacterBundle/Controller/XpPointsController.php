<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\XpPointsType;
use Symfony\Component\HttpFoundation\Request;

class XpPointsController extends Controller
{
    public function editXpPointsAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $repositoryXpPoint = $em->getRepository('DnDInstanceCharacterBundle:XpPoints');
 
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        $xpPoints = $repositoryXpPoint->findOneBy(array('characterUsed' => $characterUsed));
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        
        $form = $this->createForm(new XpPointsType, $xpPoints);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $xpPoints->setIncrease(intval($form->get('increaseAdd')->getData())+$xpPoints->getIncrease());
            $em->persist($xpPoints);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, vos XP ont bien été édités.' );
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:xpPoints/edit_xpPoints.html.twig', array(
                                'xpPoints' => $xpPoints,
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
