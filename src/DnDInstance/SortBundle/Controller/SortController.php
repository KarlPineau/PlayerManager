<?php

namespace DnDInstance\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\SortBundle\Entity\SortInstance;
use DnDInstance\SortBundle\Form\SortInstanceType;

class SortController extends Controller
{
    public function instanceForCharacterAction($characterSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);

        $sortInstance = new SortInstance;
        $sortInstance->setCreateUser($this->getUser());
        $sortInstance->setCharacterUsedSorts($characterUsed);
        
        $form = $this->createForm(new SortInstanceType, $sortInstance);
 
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($sortInstance);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le sort a bien été ajoutée au personnage.');
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterSlug)));
                }
            }
        return $this->render('DnDInstanceSortBundle:Sort:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }
}
