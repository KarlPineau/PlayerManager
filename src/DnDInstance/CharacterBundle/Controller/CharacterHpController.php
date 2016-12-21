<?php

namespace DnDInstance\CharacterBundle\Controller;

use DnDInstance\CharacterBundle\Form\CharacterUsedHpMaxEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedHpCurrentEditType;
use Symfony\Component\HttpFoundation\Request;

class CharacterHpController extends Controller
{
    public function editHpCurrentAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // -- Récupération du personnage et des compétences :
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        
        $form = $this->createForm(new CharacterUsedHpCurrentEditType, $characterUsed);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->setHpCurrent($characterUsed->getHpCurrent()+intval($form->get('hpCurrentAdd')->getData()));
            if($characterUsed->getHpCurrent() > $characterUsed->getHpMax()) {
                $characterUsed->setHpCurrent($characterUsed->getHpMax());
                $this->get('session')->getFlashBag()->add('notice', 'Oups ... Vous cherchez à avoir plus de points de vie que permis ...' );
            } else {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
            }
            $em->persist($characterUsed);
            $em->flush();

            //Renvoie vers la page de gestion des Caractéristiques :
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:hp/edit_hpCurrent.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }

    public function editHpMaxAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // -- Récupération du personnage et des compétences :
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        if ($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$slug.'] inexistant.');}

        $form = $this->createForm(new CharacterUsedHpMaxEditType(), $characterUsed);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->setHpMax(intval($form->get('hpMaxAdd')->getData())+$characterUsed->getHpMax());
            $em->persist($characterUsed);
            $em->flush ();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
            //Renvoie vers la page de gestion des Caractéristiques :
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }

        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:hp/edit_hpMax.html.twig', array(
            'characterUsed' => $characterUsed,
            'form' => $form->createView(),
        ));
    }
}
