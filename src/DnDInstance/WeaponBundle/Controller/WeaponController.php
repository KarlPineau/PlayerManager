<?php

namespace DnDInstance\WeaponBundle\Controller;

use DnDInstance\WeaponBundle\Form\WeaponInstanceEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\WeaponBundle\Entity\WeaponInstance;
use DnDInstance\WeaponBundle\Form\WeaponInstanceType;
use Symfony\Component\HttpFoundation\Request;

class WeaponController extends Controller
{
    public function instanceForCharacterAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null OR ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $weaponInstance = new WeaponInstance();
        $form = $this->createForm(new WeaponInstanceType, $weaponInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->addWeapon($weaponInstance);
            $weaponInstance->setCreateUser($this->getUser());
            $weaponInstance->setCharacterUsedWeapons($characterUsed);
            $em->persist($weaponInstance);
            $em->flush();
            $weaponInstance = $this->get('dndinstance_weapon.weaponinstance')->instanceWeapon($weaponInstance);

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'arme a bien été ajoutée au personnage.');
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceWeaponBundle:Weapon:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }

    public function removeCharacterFromInstanceAction($characterUsed_id, $instance_id, $game_id)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($characterUsed_id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUser [id='.$characterUsed_id.'] undefined.');}
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneBy(array('id' => $instance_id, 'characterUsedWeapons' => $characterUsed));
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$instance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBy(array('id' => $game_id));
        if($game === null) {throw $this->createNotFoundException('Game [id='.$game_id.'] undefined.');}

        $weaponInstance = $this->get('dndinstance_weapon.weaponinstance')->removeFromCharacter($weaponInstance, $characterUsed, $game);
        $this->get('session')->getFlashBag()->add('notice', 'L\'arme a bien été retirée au personnage.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
    }

    public function editInstanceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneById($id);
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$id.'] undefined.');}

        $form = $this->createForm(new WeaponInstanceEditType(), $weaponInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($weaponInstance);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre arme a bien été éditée.' );
            if($weaponInstance->getCharacterUsed() != null) {
                return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $weaponInstance->getCharacterUsed()->getSlug()));
            } elseif($weaponInstance->getGame() != null) {
                return $this->redirectToRoute('game_game_game_view', array('slug' => $weaponInstance->getGame()->getSlug()));
            }
        }

        return $this->render('DnDInstanceWeaponBundle:Weapon:Edit/edit.html.twig', array(
            'form' => $form->createView(),
            'weaponInstance' => $weaponInstance
        ));
    }
}
