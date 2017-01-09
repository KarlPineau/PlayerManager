<?php

namespace DnDInstance\ArmorBundle\Controller;

use DnDInstance\ArmorBundle\Form\ArmorInstanceEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\ArmorBundle\Entity\ArmorInstance;
use DnDInstance\ArmorBundle\Form\ArmorInstanceType;
use Symfony\Component\HttpFoundation\Request;

class ArmorController extends Controller
{
    public function instanceForCharacterAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if ($characterUsed === null) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $armorInstance = new ArmorInstance;
        $form = $this->createForm(new ArmorInstanceType, $armorInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $armorInstance->setCreateUser($this->getUser());
            $armorInstance->setCharacterUsed($characterUsed);
            $armorInstance = $this->get('dndinstance_armor.armorinstance')->instanceArmor($armorInstance);
            $this->get('dndinstance_armor.armorinstance')->wearArmor($characterUsed, $armorInstance);

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été ajoutée au personnage.');
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceArmorBundle:Armor:register_content.html.twig', array(
            'form' => $form->createView(),
            'characterUsed' => $characterUsed,
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $instance = $em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findOneById($id);
        if($instance === null) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $form = $this->createForm(new ArmorInstanceEditType(), $instance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($instance);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été ajoutée au personnage.');
            return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $instance->getCharacterUsed()->getSlug()));
        }

        return $this->render('DnDInstanceArmorBundle:Armor:Edit/edit.html.twig', array(
            'form' => $form->createView(),
            'characterUsed' => $instance->getCharacterUsed(),
            'armorInstance' => $instance,
        ));
    }

    public function wearAction($characterUsed_id, $instance_id)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($characterUsed_id);
        if ($characterUsed === null) {throw $this->createNotFoundException('CharacterUsed [id='.$characterUsed_id.'] undefined.');}

        $instance = $em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findOneById($instance_id);
        if($instance->getCharacterUsed() == $characterUsed) {
            $this->get('dndinstance_armor.armorinstance')->wearArmor($characterUsed, $instance);
        }

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été ajoutée au personnage.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
    }

    public function removeFromCharacterAction($characterUsed_id, $instance_id)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($characterUsed_id);
        if ($characterUsed === null) {throw $this->createNotFoundException('CharacterUsed [id='.$characterUsed_id.'] undefined.');}

        $instance = $em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findOneById($instance_id);
        if($instance->getCharacterUsed() == $characterUsed) {
            $this->get('dndinstance_armor.armorinstance')->discardArmor($characterUsed, $instance);
        }

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le personnage s\'est bien défaussé de cette armure.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
    }

    public function removeAction($instance_id, $game_id)
    {
        $em = $this->getDoctrine()->getManager();
        $armorInstance = $em->getRepository('DnDInstanceArmorBundle:ArmorInstance')->findOneBy(array('id' => $instance_id));
        if($armorInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$instance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBy(array('id' => $game_id));
        if($game === null) {throw $this->createNotFoundException('Game [id='.$game_id.'] undefined.');}

        $this->get('dndinstance_armor.armorinstance')->remove($armorInstance);

        $this->get('session')->getFlashBag()->add('notice', 'L\'armure a bien été supprimée.');
        return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
    }
}
