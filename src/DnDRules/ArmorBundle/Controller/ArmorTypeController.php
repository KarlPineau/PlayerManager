<?php

namespace DnDRules\ArmorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\ArmorBundle\Entity\ArmorType;
use DnDRules\ArmorBundle\Form\ArmorTypeRegisterType;
use DnDRules\ArmorBundle\Form\ArmorTypeEditType;

class ArmorTypeController extends Controller
{
    public function indexAction()
    {
        $listArmorTypes = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:ArmorType')->findAll();
        return $this->render('DnDRulesArmorBundle:ArmorType:index.html.twig', array(
            'listArmorTypes' => $listArmorTypes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $armortype = new ArmorType;

        $form = $this->createForm(new ArmorTypeRegisterType, $armortype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $armortype->setCreateUser($this->getUser());
                    $em->persist($armortype);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type d\'armure a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_armor_armortype_view', array('slug' => $armortype->getSlug())));
                }
            }
        return $this->render('DnDRulesArmorBundle:ArmorType:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $armortype = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:ArmorType')->findOneBySlug($slug);
        if ($armortype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Type d\'Armure : [slug='.$slug.'] inexistante.');}
        
        return $this->render('DnDRulesArmorBundle:ArmorType:view.html.twig', array(
                                'armortype' => $armortype,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $armortype = $em->getRepository('DnDRulesArmorBundle:ArmorType')->findOneBySlug($slug);
        if ($armortype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Type d\'Armure : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new ArmorTypeEditType, $armortype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $armortype->setUpdateUser($this->getUser());
                    $em->persist($armortype);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type d\'armure a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_armor_armortype_view', array('slug' => $armortype->getSlug())));
                }
            }
        
        return $this->render('DnDRulesArmorBundle:ArmorType:Edit/edit.html.twig', array(
                                'armortype' => $armortype,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $armortype = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:ArmorType')->findOneBySlug($slug);
        if ($armortype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Type d\'Armure : [slug='.$slug.'] inexistante.');}
        
        $deleteArmorType = $this->container->get('dndrules_character.deletearmortype');
        $deleteArmorType->deleteArmorType($armortype);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre type d\'armure a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_armor_armortype_home');
    }
}
