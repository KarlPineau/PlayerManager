<?php

namespace DnDRules\WeaponBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\WeaponBundle\Entity\WeaponType;
use DnDRules\WeaponBundle\Form\WeaponTypeRegisterType;
use DnDRules\WeaponBundle\Form\WeaponTypeEditType;

class WeaponTypeController extends Controller
{
    public function indexAction()
    {
        $listWeaponTypes = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:WeaponType')->findAll();
        return $this->render('DnDRulesWeaponBundle:WeaponType:index.html.twig', array(
            'listWeaponTypes' => $listWeaponTypes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $weapontype = new WeaponType;

        $form = $this->createForm(new WeaponTypeRegisterType, $weapontype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $weapontype->setCreateUser($this->getUser());
                    $em->persist($weapontype);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le type d\'arme a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_weapon_weapontype_view', array('slug' => $weapontype->getSlug())));
                }
            }
        return $this->render('DnDRulesWeaponBundle:WeaponType:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $weapontype = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:WeaponType')->findOneBySlug($slug);
        if ($weapontype === null) {throw $this->createNotFoundException('WeaponType : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesWeaponBundle:WeaponType:view.html.twig', array(
                                'weapontype' => $weapontype,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $weapontype = $em->getRepository('DnDRulesWeaponBundle:WeaponType')->findOneBySlug($slug);
        if ($weapontype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('WeaponType : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new WeaponTypeEditType, $weapontype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $weapontype->setUpdateUser($this->getUser());
                    $em->persist($weapontype);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type d\'arme a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_weapon_weapontype_view', array('slug' => $weapontype->getSlug())));
                }
            }
        
        return $this->render('DnDRulesWeaponBundle:WeaponType:Edit/edit.html.twig', array(
                                'weapontype' => $weapontype,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $weapontype = $this->getDoctrine()->getManager()->getRepository('DnDRulesWeaponBundle:WeaponType')->findOneBySlug($slug);
        if($weapontype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('WeaponType : [slug='.$slug.'] inexistant.');}
        
        $weapontypeAction = $this->container->get('dndrules_weapon.weapontypeaction');
        $weapontypeAction->deleteWeaponType($weapontype);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre type d\'arme a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_weapon_weapontype_home');
    }
}
