<?php

namespace DnDRules\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\MonsterSubType;
use DnDRules\MonsterBundle\Form\MonsterSubTypeRegisterType;
use DnDRules\MonsterBundle\Form\MonsterSubTypeEditType;

class MonsterSubTypeController extends Controller
{
    public function indexAction()
    {
        $listMonsterSubTypes = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterSubType')->findAll();
        return $this->render('DnDRulesMonsterBundle:MonsterSubType:index.html.twig', array(
            'listMonsterSubTypes' => $listMonsterSubTypes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $monstersubtype = new MonsterSubType;
        
        $form = $this->createForm(new MonsterSubTypeRegisterType, $monstersubtype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monstersubtype->setCreateUser($this->getUser());
                    $em->persist($monstersubtype);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre sous-type a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monstersubtype_view', array('slug' => $monstersubtype->getSlug())));
                }
            }
        return $this->render('DnDRulesMonsterBundle:MonsterSubType:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $monstersubtype = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterSubType')->findOneBySlug($slug);
        if ($monstersubtype === null) {throw $this->createNotFoundException('MonsterSubType : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesMonsterBundle:MonsterSubType:view.html.twig', array(
                                'monstersubtype' => $monstersubtype,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $monstersubtype = $em->getRepository('DnDRulesMonsterBundle:MonsterSubType')->findOneBySlug($slug);
        if($monstersubtype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterSubType : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new MonsterSubTypeEditType, $monstersubtype);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monstersubtype->setUpdateUser($this->getUser());
                    $em->persist($monstersubtype);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre sous-type a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monstersubtype_view', array('slug' => $monstersubtype->getSlug())));
                }
            }
        
        return $this->render('DnDRulesMonsterBundle:MonsterSubType:Edit/edit.html.twig', array(
                                'monstersubtype' => $monstersubtype,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $monstersubtype = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:MonsterSubType')->findOneBySlug($slug);
        if($monstersubtype === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterSubType : [slug='.$slug.'] inexistant.');}
        
        $monstersubtypeAction = $this->container->get('dndrules_monster.monstersubtypeaction');
        $monstersubtypeAction->deleteMonsterSubType($monstersubtype);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre sous-type a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_monstersubtype_home');
    }
}
