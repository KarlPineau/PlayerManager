<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\XpPointsType;

class XpPointsController extends Controller
{
    public function editXpPointsAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $repositoryXpPoint = $em->getRepository('DnDInstanceCharacterBundle:XpPoints');
 
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        $xpPoints = $repositoryXpPoint->findOneBy(array('characterUsed' => $characterUsed));

        
        $form = $this->createForm(new XpPointsType, $xpPoints);
        
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($xpPoints);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, vos XP ont bien été édités.' );
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:xpPoints/edit_xpPoints.html.twig', array(
                                'xpPoints' => $xpPoints,
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}