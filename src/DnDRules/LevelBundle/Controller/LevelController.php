<?php

namespace DnDRules\LevelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\LevelBundle\Entity\Level;
use DnDRules\LevelBundle\Form\LevelRegisterType;
use DnDRules\LevelBundle\Form\LevelEditType;

class LevelController extends Controller
{
    public function indexAction()
    {
        $listLevels = $this->getDoctrine()->getManager()->getRepository('DnDRulesLevelBundle:Level')->findAll();
        return $this->render('DnDRulesLevelBundle:Level:index.html.twig', array(
            'listLevels' => $listLevels,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $level = new Level;
        
        $form = $this->createForm(new LevelRegisterType, $level);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $level->setCreateUser($this->getUser());
                    $em->persist($level);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre niveau a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_level_level_view', array('level' => $level->getLevel())));
                }
            }
        return $this->render('DnDRulesLevelBundle:Level:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($level)
    {
        $levelObject = $this->getDoctrine()->getManager()->getRepository('DnDRulesLevelBundle:Level')->findOneByLevel($level);
        if ($levelObject === null) {throw $this->createNotFoundException('Niveau : [slug='.$level.'] inexistant.');}
        
        return $this->render('DnDRulesLevelBundle:Level:view.html.twig', array(
                                'level' => $levelObject,
                            ));
    }
    
    public function editAction($level)
    {
        $em = $this->getDoctrine()->getManager();
        $levelObject = $em->getRepository('DnDRulesLevelBundle:Level')->findOneByLevel($level);
        if ($levelObject === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Niveau : [slug='.$level.'] inexistant.');}
        
        $form = $this->createForm(new LevelEditType, $levelObject);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $levelObject->setUpdateUser($this->getUser());
                    $em->persist($levelObject);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre niveau a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_level_level_view', array('level' => $levelObject->getLevel())));
                }
            }
        
        return $this->render('DnDRulesLevelBundle:Level:Edit/edit.html.twig', array(
                                'level' => $levelObject,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($level)
    {
        $levelObject = $this->getDoctrine()->getManager()->getRepository('DnDRulesLevelBundle:Level')->findOneByLevel($level);
        if ($levelObject === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Niveau : [slug='.$level.'] inexistant.');}
        
        $deleteLevel = $this->container->get('dndrules_character.deletelevel');
        $deleteLevel->deleteLevel($levelObject);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre niveau a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_level_level_home');
    }
}
