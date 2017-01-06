<?php

namespace DnDRules\ArmorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\ArmorBundle\Entity\Armor;
use DnDRules\ArmorBundle\Form\ArmorRegisterType;
use DnDRules\ArmorBundle\Form\ArmorEditType;

class ArmorController extends Controller
{
    public function indexAction()
    {
        $listArmors = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:Armor')->findBy(array(), array('type' => 'ASC', 'name' => 'ASC'));
        return $this->render('DnDRulesArmorBundle:Armor:index.html.twig', array(
            'listArmors' => $listArmors,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}

        $armor = new Armor;
        $form = $this->createForm(new ArmorRegisterType, $armor);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $armor->setCreateUser($this->getUser());
                    $em->persist($armor);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'armure a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_armor_armor_view', array('slug' => $armor->getSlug())));
                }
            }
        return $this->render('DnDRulesArmorBundle:Armor:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $armor = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:Armor')->findOneBySlug($slug);
        if ($armor === null) {throw $this->createNotFoundException('Armor : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesArmorBundle:Armor:view.html.twig', array(
                                'armor' => $armor,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $armor = $em->getRepository('DnDRulesArmorBundle:Armor')->findOneBySlug($slug);
        if ($armor === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Armor : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new ArmorEditType, $armor);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $armor->setUpdateUser($this->getUser());
                    $em->persist($armor);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre armure a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_armor_armor_view', array('slug' => $armor->getSlug())));
                }
            }
        
        return $this->render('DnDRulesArmorBundle:Armor:Edit/edit.html.twig', array(
                                'armor' => $armor,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $armor = $this->getDoctrine()->getManager()->getRepository('DnDRulesArmorBundle:Armor')->findOneBySlug($slug);
        if ($armor === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Armor : [slug='.$slug.'] inexistant.');}
        
        $armorAction = $this->container->get('dndrules_armor.armoraction');
        $armorAction->deleteArmor($armor);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre armure a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_armor_armor_home');
    }
}
