<?php

namespace DnDRules\WeaponBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\WeaponBundle\Entity\Weapon;
use DnDRules\WeaponBundle\Form\WeaponRegisterType;
use DnDRules\WeaponBundle\Form\WeaponEditType;
use Symfony\Component\HttpFoundation\Request;

class WeaponController extends Controller
{
    public function indexAction()
    {
        $listWeapons = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:Weapon')->findBy(array(), array('weaponType' => 'ASC', 'name' => 'ASC'));
        return $this->render('DnDRulesWeaponBundle:Weapon:index.html.twig', array(
            'listWeapons' => $listWeapons,
        ));
    }
    
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $weapon = new Weapon;

        $form = $this->createForm(new WeaponEditType(), $weapon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weapon->setCreateUser($this->getUser());
            // -- Gestion de la classe
            $weaponDamages = $weapon->getDamages();
            foreach ($weaponDamages as $weaponDamage) {
                $weaponDamage->setCreateUser($this->getUser());
                $weaponDamage->setWeapon($weapon);
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
            $criticals = $weapon->getCriticals();
            foreach ($criticals as $critical) {
                $critical->setWeapon($weapon);
                $em->persist($critical);
            }

            $em->persist($weapon);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'arme a bien été créée.');
            return $this->redirect($this->generateUrl('dndrules_weapon_weapon_view', array('slug' => $weapon->getSlug())));
        }
        return $this->render('DnDRulesWeaponBundle:Weapon:Edit/edit.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $weapon = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:Weapon')->findOneBySlug($slug);
        if ($weapon === null) {throw $this->createNotFoundException('Weapon : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesWeaponBundle:Weapon:view.html.twig', array(
                                'weapon' => $weapon,
                            ));
    }
    
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $weapon = $em->getRepository('DnDRulesWeaponBundle:Weapon')->findOneBySlug($slug);
        if($weapon === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Weapon : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new WeaponEditType, $weapon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weapon->setUpdateUser($this->getUser());
            $em->persist($weapon);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre arme a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_weapon_weapon_view', array('slug' => $weapon->getSlug())));
        }
        return $this->render('DnDRulesWeaponBundle:Weapon:Edit/edit.html.twig', array(
                                'weapon' => $weapon,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $weapon = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:Weapon')->findOneBySlug($slug);
        if($weapon === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Weapon : [slug='.$slug.'] inexistant.');}
        
        $weaponAction = $this->container->get('dndrules_weapon.weaponaction');
        $weaponAction->deleteWeapon($weapon);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre arme a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_weapon_weapon_home');
    }
}
