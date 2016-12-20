<?php

namespace DnDRules\AbilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\AbilityBundle\Entity\Ability;
use DnDRules\AbilityBundle\Form\AbilityRegisterType;
use DnDRules\AbilityBundle\Form\AbilityEditType;

class AbilityController extends Controller
{
    public function indexAction()
    {
        $listAbilities = $this->getDoctrine()->getManager()->getRepository('DnDRulesAbilityBundle:Ability')->findAll();
        return $this->render('DnDRulesAbilityBundle:Ability:index.html.twig', array(
            'listAbilities' => $listAbilities,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}

        $ability = new Ability;
        $ability->setCreateUser($this->getUser());
        
        $form = $this->createForm(new AbilityRegisterType, $ability);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($ability);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre caractéristique a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_ability_ability_view', array('slug' => $ability->getSlug())));
                }
            }
        return $this->render('DnDRulesAbilityBundle:Ability:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $ability = $this->getDoctrine()->getManager()->getRepository('DnDRulesAbilityBundle:Ability')->findOneBySlug($slug);
        if ($ability === null) {throw $this->createNotFoundException('Caractéristique : [slug='.$slug.'] inexistante.');}
        
        return $this->render('DnDRulesAbilityBundle:Ability:view.html.twig', array(
                                'ability' => $ability,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $ability = $em->getRepository('DnDRulesAbilityBundle:Ability')->findOneBySlug($slug);
        if ($ability === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Caractéristique : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new AbilityEditType, $ability);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $ability->setUpdateUser($this->getUser());
                    $em->persist($ability);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre caractéristique a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_ability_ability_view', array('slug' => $ability->getSlug())));
                }
            }
        
        return $this->render('DnDRulesAbilityBundle:Ability:Edit/edit.html.twig', array(
                                'ability' => $ability,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $ability = $this->getDoctrine()->getManager()->getRepository('DnDRulesAbilityBundle:Ability')->findOneBySlug($slug);
        if ($ability === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Caractéristique : [slug='.$slug.'] inexistante.');}
        
        $deleteAbility = $this->container->get('dndrules_ability.deleteability');
        $deleteAbility->deleteAbility($ability);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre caractéristique a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_ability_ability_home');
    }
}
