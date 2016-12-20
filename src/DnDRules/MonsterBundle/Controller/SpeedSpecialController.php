<?php

namespace DnDRules\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\SpeedSpecial;
use DnDRules\MonsterBundle\Form\SpeedSpecialRegisterType;
use DnDRules\MonsterBundle\Form\SpeedSpecialEditType;

class SpeedSpecialController extends Controller
{
    public function indexAction()
    {
        $listSpeedSpecials = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:SpeedSpecial')->findAll();
        return $this->render('DnDRulesMonsterBundle:SpeedSpecial:index.html.twig', array(
            'listSpeedSpecials' => $listSpeedSpecials,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $speedspecial = new SpeedSpecial;
        
        $form = $this->createForm(new SpeedSpecialRegisterType, $speedspecial);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $speedspecial->setCreateUser($this->getUser());
                    $em->persist($speedspecial);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le type de déplacement a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_speedspecial_view', array('slug' => $speedspecial->getSlug())));
                }
            }
        return $this->render('DnDRulesMonsterBundle:SpeedSpecial:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $speedspecial = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:SpeedSpecial')->findOneBySlug($slug);
        if ($speedspecial === null) {throw $this->createNotFoundException('SpeedSpecial : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesMonsterBundle:SpeedSpecial:view.html.twig', array(
                                'speedspecial' => $speedspecial,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $speedspecial = $em->getRepository('DnDRulesMonsterBundle:SpeedSpecial')->findOneBySlug($slug);
        if($speedspecial === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('SpeedSpecial : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new SpeedSpecialEditType, $speedspecial);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $speedspecial->setUpdateUser($this->getUser());
                    $em->persist($speedspecial);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre type de déplacement a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_speedspecial_view', array('slug' => $speedspecial->getSlug())));
                }
            }
        
        return $this->render('DnDRulesMonsterBundle:SpeedSpecial:Edit/edit.html.twig', array(
                                'speedspecial' => $speedspecial,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $speedspecial = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:SpeedSpecial')->findOneBySlug($slug);
        if($speedspecial === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('SpeedSpecial : [slug='.$slug.'] inexistant.');}
        
        $speedspecialAction = $this->container->get('dndrules_monster.speedspecialaction');
        $speedspecialAction->deleteSpeedSpecial($speedspecial);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre type de déplacement a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_speedspecial_home');
    }
}
