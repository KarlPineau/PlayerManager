<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedHpCurrentEditType;

class CharacterHpController extends Controller
{
    public function editHpCurrentAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $current_user = $this->getUser();
        // -- Récupération du personnage et des compétences :
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        
        // -- Création du formulaire :
        $form = $this->createForm(new CharacterUsedHpCurrentEditType, $characterUsed);
        
        // -- Validation du formulaire :
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($characterUsed);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                    //Renvoie vers la page de gestion des Caractéristiques :
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:hp/edit_hpCurrent.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
