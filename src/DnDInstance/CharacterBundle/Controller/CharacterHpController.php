<?php

namespace DnDInstance\CharacterBundle\Controller;

use DnDInstance\CharacterBundle\Form\CharacterUsedHpMaxEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedHpCurrentEditType;
use Symfony\Component\HttpFoundation\Request;

class CharacterHpController extends Controller
{
    public function editHpCurrentAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() and !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed : [id='.$id.'] undefined.');}

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

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre nombre de points de vie a bien été édité.' );
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Hp/edit_hpCurrent.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }

    public function editHpMaxAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed : [id='.$id.'] undefined.');}

        $form = $this->createForm(new CharacterUsedHpMaxEditType(), $characterUsed);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($context == 'edit') {
                $characterUsed->setHpMax(intval($form->get('hpMaxAdd')->getData())+$characterUsed->getHpMax());
            } elseif($context == 'register' OR $context == 'levelUp') {
                $characterUsed->setHpMax(
                    $characterUsed->getHpMax()
                    +intval($form->get('hpMaxAdd')->getData())
                    +intval($this->get('dndinstance_character.characterusedability')->getConstitutionModifier($characterUsed))
                );
                $characterUsed->setHpCurrent(
                    $characterUsed->getHpCurrent()
                    +intval($form->get('hpMaxAdd')->getData())
                    +intval($this->get('dndinstance_character.characterusedability')->getConstitutionModifier($characterUsed))
                );
            }

            $em->persist($characterUsed);
            $em->flush ();

            if($context == 'edit' or $context == 'levelUp') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
            } elseif($context == 'register') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage est à présent créé !' );
                return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug(), 'context' => 'register'));
            }
        }

        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Hp/edit_hpMax.html.twig', array(
            'characterUsed' => $characterUsed,
            'form' => $form->createView(),
            'context' => $context
        ));
    }
}
