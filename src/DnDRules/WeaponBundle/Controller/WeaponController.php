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
    
    public function viewAction($slug)
    {
        $weapon = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:Weapon')->findOneBySlug($slug);
        if ($weapon === null) {throw $this->createNotFoundException('Weapon : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesWeaponBundle:Weapon:view.html.twig', array(
                                'weapon' => $weapon,
                            ));
    }
    
    public function editAction($id=null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($id != null) {
            $weapon = $em->getRepository('DnDRulesWeaponBundle:Weapon')->findOneById($id);
            if($weapon === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Weapon [id='.$id.'] undefined.');}
        } else {
            $weapon = new Weapon();
            $weapon->setCreateUser($this->getUser());
        }
        
        $form = $this->createForm(new WeaponEditType, $weapon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weapon->setUpdateUser($this->getUser());

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

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre arme a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_weapon_weapon_view', array('slug' => $weapon->getSlug())));
        }
        return $this->render('DnDRulesWeaponBundle:Weapon:Edit/edit.html.twig', array(
                                'weapon' => $weapon,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($id)
    {
        $weapon = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:Weapon')->findOneById($id);
        if($weapon === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Weapon : [slug='.$slug.'] inexistant.');}
        
        $weaponAction = $this->container->get('dndrules_weapon.weaponaction');
        $weaponAction->deleteWeapon($weapon);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre arme a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_weapon_weapon_home');
    }
}
