<?php

namespace DnDRules\EquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\EquipmentBundle\Entity\Equipment;
use DnDRules\EquipmentBundle\Form\EquipmentRegisterType;
use DnDRules\EquipmentBundle\Form\EquipmentEditType;

class EquipmentController extends Controller
{
    public function indexAction()
    {
        $listEquipments = $this->getDoctrine()->getManager()->getRepository('DnDRulesEquipmentBundle:Equipment')->findAll();
        return $this->render('DnDRulesEquipmentBundle:Equipment:index.html.twig', array(
            'listEquipments' => $listEquipments,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $equipment = new Equipment;
        $form = $this->createForm(new EquipmentRegisterType, $equipment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $equipment->setCreateUser($this->getUser());
                    $em->persist($equipment);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'équipement a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_equipment_equipment_view', array('slug' => $equipment->getSlug())));
                }
            }
        return $this->render('DnDRulesEquipmentBundle:Equipment:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $equipment = $this->getDoctrine()->getManager()->getRepository('DnDRulesEquipmentBundle:Equipment')->findOneBySlug($slug);
        if ($equipment === null) {throw $this->createNotFoundException('Equipment : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesEquipmentBundle:Equipment:view.html.twig', array(
                                'equipment' => $equipment,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('DnDRulesEquipmentBundle:Equipment')->findOneBySlug($slug);
        if ($equipment === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Equipment : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new EquipmentEditType, $equipment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $equipment->setUpdateUser($this->getUser());
                    $em->persist($equipment);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre équipement a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_equipment_equipment_view', array('slug' => $equipment->getSlug())));
                }
            }
        
        return $this->render('DnDRulesEquipmentBundle:Equipment:Edit/edit.html.twig', array(
                                'equipment' => $equipment,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $equipment = $this->getDoctrine()->getManager()->getRepository('DnDRulesEquipmentBundle:Equipment')->findOneBySlug($slug);
        if ($equipment === null or $equipment === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Equipment : [slug='.$slug.'] inexistant.');}
        
        $equipmentAction = $this->container->get('dndrules_equipment.equipmentaction');
        $equipmentAction->deleteEquipment($equipment);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre équipement a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_equipment_equipment_home');
    }
}
