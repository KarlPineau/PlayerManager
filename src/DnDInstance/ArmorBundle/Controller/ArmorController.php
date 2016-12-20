<?php

namespace DnDInstance\ArmorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\ArmorBundle\Entity\ArmorInstance;
use DnDInstance\ArmorBundle\Form\ArmorInstanceType;

class ArmorController extends Controller
{
    public function instanceForCharacterAction($characterSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$characterSlug.'] inexistant.');}

        $armorInstance = new ArmorInstance;
        $armorInstance->setCreateUser($this->getUser());
        $armorInstance->setCharacterUsedArmors($characterUsed);
        
        $form = $this->createForm(new ArmorInstanceType, $armorInstance);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($armorInstance);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été ajoutée au personnage.');
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterSlug)));
                }
            }
        return $this->render('DnDInstanceArmorBundle:Armor:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }
}
