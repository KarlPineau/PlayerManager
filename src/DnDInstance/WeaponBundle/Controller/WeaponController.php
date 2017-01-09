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
            $weaponInstance->setCreateUser($this->getUser());
            $weaponInstance->setCharacterUsed($characterUsed);
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

    public function removeFromCharacterAction($characterUsed_id, $instance_id, $game_id)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($characterUsed_id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUser [id='.$characterUsed_id.'] undefined.');}
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneBy(array('id' => $instance_id, 'characterUsed' => $characterUsed));
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$instance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBy(array('id' => $game_id));
        if($game === null) {throw $this->createNotFoundException('Game [id='.$game_id.'] undefined.');}

        $weaponInstance = $this->get('dndinstance_weapon.weaponinstance')->removeFromCharacter($weaponInstance, $characterUsed, $game);
        $this->get('session')->getFlashBag()->add('notice', 'L\'arme a bien été retirée au personnage.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
    }

    public function removeAction($instance_id, $game_id)
    {
        $em = $this->getDoctrine()->getManager();
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneBy(array('id' => $instance_id));
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$instance_id.'] undefined.');}
        $game = $em->getRepository('GameGameBundle:Game')->findOneBy(array('id' => $game_id));
        if($game === null) {throw $this->createNotFoundException('Game [id='.$game_id.'] undefined.');}

        $this->get('dndinstance_weapon.weaponinstance')->remove($weaponInstance);

        $this->get('session')->getFlashBag()->add('notice', 'L\'arme a bien été supprimée.');
        return $this->redirect($this->generateUrl('game_game_game_view', array('slug' => $game->getSlug())));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $weaponInstance = $em->getRepository('DnDInstanceWeaponBundle:WeaponInstance')->findOneById($id);
        if($weaponInstance === null) {throw $this->createNotFoundException('WeaponInstance [id='.$id.'] undefined.');}

        $form = $this->createForm(new WeaponInstanceEditType(), $weaponInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($weaponInstance);

            $weaponDamages = $weaponInstance->getDamages();
            foreach ($weaponDamages as $weaponDamage) {
                $weaponDamage->setCreateUser($this->getUser());
                $weaponDamage->setWeaponInstance($weaponInstance);
                $em->persist($weaponDamage);

                $diceForms = $weaponDamage->getDamages();
                foreach ($diceForms as $diceForm) {
                    $diceForm->setWeaponDamage($weaponDamage);
                    $em->persist($diceForm);

                    $diceEntities = $diceForm->getDiceEntities();
                    foreach ($diceEntities as $diceEntity) {
                        $diceEntity->setDiceForm($diceForm);
                        $em->persist($diceEntity);
                    }

                    $bonusNumbers = $diceForm->getBonusNumbers();
                    foreach ($bonusNumbers as $bonusNumber) {
                        $bonusNumber->setDiceForm($diceForm);
                        $em->persist($bonusNumber);
                    }
                }
            }
            $criticals = $weaponInstance->getCriticals();
            foreach ($criticals as $critical) {
                $critical->setWeaponInstance($weaponInstance);
                $em->persist($critical);
            }

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
