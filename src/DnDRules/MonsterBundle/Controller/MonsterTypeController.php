<?php

namespace DnDRules\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\MonsterType;
use DnDRules\MonsterBundle\Form\MonsterTypeRegisterType;
use DnDRules\MonsterBundle\Form\MonsterTypeEditType;

class MonsterTypeController extends Controller
{
    public function indexAction()
    {
        $listMonsterTypes = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterType')->findAll();
        return $this->render('DnDRulesMonsterBundle:MonsterType:index.html.twig', array(
            'listMonsterTypes' => $listMonsterTypes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $monstertype = new MonsterType;
        
        $form = $this->createForm(new MonsterTypeRegisterType, $monstertype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monstertype->setCreateUser($this->getUser());
                    $em->persist($monstertype);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type de monstre a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monstertype_view', array('slug' => $monstertype->getSlug())));
                }
            }
        return $this->render('DnDRulesMonsterBundle:MonsterType:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $monstertype = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterType')->findOneBySlug($slug);
        if($monstertype === null) {throw $this->createNotFoundException('MonsterType : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesMonsterBundle:MonsterType:view.html.twig', array(
                                'monstertype' => $monstertype,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $monstertype = $em->getRepository('DnDRulesMonsterBundle:MonsterType')->findOneBySlug($slug);
        if($monstertype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterType : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new MonsterTypeEditType, $monstertype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monstertype->setUpdateUser($this->getUser());
                    $em->persist($monstertype);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type de monstre a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monstertype_view', array('slug' => $monstertype->getSlug())));
                }
            }
        
        return $this->render('DnDRulesMonsterBundle:MonsterType:Edit/edit.html.twig', array(
                                'monstertype' => $monstertype,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $monstertype = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterType')->findOneBySlug($slug);
        if($monstertype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterType : [slug='.$slug.'] inexistant.');}
        
        $monstertypeAction = $this->container->get('dndrules_monster.monstertypeaction');
        $monstertypeAction->deleteMonsterType($monstertype);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre type de monstre a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_monstertype_home');
    }
}
