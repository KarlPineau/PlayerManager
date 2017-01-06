<?php

namespace DnDInstance\WeaponBundle\Controller;

use DnDInstance\WeaponBundle\Form\WeaponInstanceEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\WeaponBundle\Entity\WeaponInstance;
use DnDInstance\WeaponBundle\Form\WeaponInstanceType;
use Symfony\Component\HttpFoundation\Request;

class WeaponController extends Controller
{
    public function instanceForCharacterAction($characterSlug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);
        if($characterUsed === null) {throw $this->createNotFoundException('Personnage : [slug='.$characterSlug.'] inexistant.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Personnage : [slug='.$characterSlug.'] inexistant.');}

        $weaponInstance = new WeaponInstance();
        $form = $this->createForm(new WeaponInstanceType, $weaponInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $characterUsed->addWeapon($weaponInstance);
            $weaponInstance->setCreateUser($this->getUser());
            $weaponInstance->setCharacterUsedWeapons($characterUsed);
            $em->persist($weaponInstance);
            $em->flush();
            $weaponInstance = $this->get('dndinstance_weapon.weaponinstance')->loadInstanceFromWeapon($weaponInstance);

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'arme a bien été ajoutée au personnage.');
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterSlug)));
        }
        return $this->render('DnDInstanceWeaponBundle:Weapon:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }

    public function removeCharacterFromInstanceAction($characterSlug, $instance_id, $gameSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($characterSlug);
        if($characterUsed === null) {throw $this->createNotFoundException('CharacterUser : [slug='.$characterSlug.'] undefined.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('CharacterUsed : [slug='.$characterSlug.'] undefined.');}
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:Weapon')->findOneBy(array('id' => $instance_id, 'characterUsedWeapons' => $characterUsed));
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance : [id='.$instance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBy(array('slug' => $gameSlug));
        if($game === null) {throw $this->createNotFoundException('Game : [slug='.$gameSlug.'] undefined.');}

        $weaponInstance = $this->get('dndinstance_weapon.weaponinstance')->removeCharacterFromInstance($weaponInstance);
        $this->get('session')->getFlashBag()->add('notice', 'L\'arme a bien été retirée au personnage.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterSlug)));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneById($id);
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance : [id='.$id.'] undefined.');}

        $form = $this->createForm(new WeaponInstanceEditType(), $weaponInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($weaponInstance);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre arme a bien été édité.' );
            if($weaponInstance->getCharacterUsed() != null) {
                return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $weaponInstance->getCharacterUsed()->getSlug()));
            } elseif($weaponInstance->getGame() != null) {
                return $this->redirectToRoute('game_game_game_view', array('slug' => $weaponInstance->getGame()->getSlug()));
            }
        }

        return $this->render('DnDInstanceWeaponBundle:Weapon:Edit/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
