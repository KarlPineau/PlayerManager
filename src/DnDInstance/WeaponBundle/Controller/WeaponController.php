<?php

namespace DnDInstance\WeaponBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\WeaponBundle\Entity\WeaponInstance;
use DnDInstance\WeaponBundle\Form\WeaponInstanceType;

class WeaponController extends Controller
{
    public function instanceForCharacterAction($characterSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$characterSlug.'] inexistant.');}

        $weaponInstance = new WeaponInstance();
        $weaponInstance->setCreateUser($this->getUser());
        $weaponInstance->setCharacterUsedWeapons($characterUsed);
        
        $form = $this->createForm(new WeaponInstanceType, $weaponInstance);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($weaponInstance);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'arme a bien été ajoutée au personnage.');
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterSlug)));
                }
            }
        return $this->render('DnDInstanceWeaponBundle:Weapon:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }
}
