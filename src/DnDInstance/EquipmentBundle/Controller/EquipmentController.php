<?php

namespace DnDInstance\EquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\EquipmentBundle\Entity\EquipmentInstance;
use DnDInstance\EquipmentBundle\Form\EquipmentInstanceType;

class EquipmentController extends Controller
{
    public function instanceForCharacterAction($characterSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$characterSlug.'] inexistant.');}

        $equipmentInstance = new EquipmentInstance;
        $equipmentInstance->setCreateUser($this->getUser());
        $equipmentInstance->setCharacterUsedEquipments($characterUsed);
        
        $form = $this->createForm(new EquipmentInstanceType, $equipmentInstance);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($equipmentInstance);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été ajoutée au personnage.');
                    return $this->redirect($this->generateUrl('dndrules_characterused_characterused_view', array('slug' => $characterSlug)));
                }
            }
        return $this->render('DnDInstanceEquipmentBundle:Equipment:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }
}
