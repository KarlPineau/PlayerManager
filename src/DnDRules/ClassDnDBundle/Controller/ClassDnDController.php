<?php

namespace DnDRules\ClassDnDBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\ClassDnDBundle\Entity\ClassDnD;
use DnDRules\ClassDnDBundle\Form\ClassDnDRegisterType;
use DnDRules\ClassDnDBundle\Form\ClassDnDEditType;
use DnDRules\ClassDnDBundle\Form\ClassBABType;
use DnDRules\ClassDnDBundle\Form\ClassSTType;

class ClassDnDController extends Controller
{
    public function indexAction()
    {
        $listClassesDnD = $this->getDoctrine()->getManager()->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findAll();
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:index.html.twig', array(
            'listClassesDnD' => $listClassesDnD,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $classDnD = new ClassDnD;
        
        $form = $this->createForm(new ClassDnDRegisterType, $classDnD);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $classDnD->setCreateUser($this->getUser());
                    $em->persist($classDnD);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la classe a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
                }
            }
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryClassDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD');
        $repositoryClassDnDLevel = $em->getRepository('DnDRulesClassDnDBundle:ClassDnDLevel');
        $repositoryLevel = $em->getRepository('DnDRulesLevelBundle:Level');
        $classDnDAction = $this->get('dndrules_classdnd.classdndaction');
 
        $classDnD = $repositoryClassDnD->findOneBySlug($slug);
        if ($classDnD === null) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $classDnDLevels = $repositoryClassDnDLevel->findBy(array('classDnD' => $classDnD),
                                                           array('level' => 'asc'));
        
        $levels = $repositoryLevel->findAll();
        $allSorts = array();
        foreach ($levels as $level) {
            $level_array = array();
            $sortsByLevel = $classDnDAction->getSortsByLevel($classDnD, $level);
            array_push($level_array, $level);
            array_push($level_array, $sortsByLevel);
            array_push($allSorts, $level_array);          
        }

        return $this->render('DnDRulesClassDnDBundle:ClassDnD:view.html.twig', array(
                                'classDnD' => $classDnD,
                                'classDnDLevels' => $classDnDLevels,
                                'allSorts' => $allSorts
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);

        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new ClassDnDEditType, $classDnD);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $classDnD->setUpdateUser($this->getUser());
                    // -- Gestion de la classe
                    $classDnDLevels = $classDnD->getLevels();
                    foreach ($classDnDLevels as $classDnDLevel) {
                        $classDnDLevel->setCreateUser($this->getUser());
                        $classDnDLevel->setClassDnD($classDnD);
                        
                        // -- Gestion des ST
                        $classSTs = $classDnDLevel->getClassST();
                        foreach ($classSTs as $classST) {
                            $classST->setCreateUser($this->getUser());
                            $classST->setClassDnDLevelST($classDnDLevel);
                            $em->persist($classST);
                        }
                        // -- Gestion des BAB
                        $classBABs = $classDnDLevel->getClassBABs();
                        foreach ($classBABs as $classBAB) {
                            $classBAB->setCreateUser($this->getUser());
                            $classBAB->setClassDnDLevelBABs($classDnDLevel);
                            $em->persist($classBAB);
                        }
                        // -- Gestion des Sorts
                        $classSorts = $classDnDLevel->getClassSorts();
                        foreach ($classSorts as $classSort) {
                            $classSort->setCreateUser($this->getUser());
                            $classSort->setClassDnDLevelSorts($classDnDLevel);
                            $em->persist($classSort);
                        }
                        
                        $em->persist($classDnDLevel);
                    }
                    $em->persist($classDnD);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
                }
            }
        
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:Edit/edit.html.twig', array(
                                'classDnD' => $classDnD,
                                'form' => $form->createView(),
                            ));
    }
    
    public function editBABAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $classDnD->setUpdateUser($this->getUser());
        $classDnD->setUpdateComment('Edition des BABs de la classe');
 
        // -- Génération du formulaire
        $form = $this->createFormBuilder()
            ->add('babs', 'collection', array('type' => new ClassBABType(),
                                              'allow_add'    => true,
                                              'allow_delete' => true))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data['babs'] as $bab) {
                $bab->setCreateUser($this->getUser());
                $em->persist($bab);
            }
            $em->persist($classDnD);
            $em->flush();
                    
            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la classe a bien été mise à jour.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
        }
        
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:editBAB.html.twig', array(
                                'classDnD' => $classDnD,
                                'form' => $form->createView(),
                            ));
    }
    
    public function editSTAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $classDnD->setUpdateUser($this->getUser());
        $classDnD->setUpdateComment('Edition des STs de la classe');
 
        // -- Génération du formulaire
        $form = $this->createFormBuilder()
            ->add('sts', 'collection',  array('type' => new ClassSTType(),
                                              'allow_add'    => true,
                                              'allow_delete' => true))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data['sts'] as $st) {
                $st->setCreateUser($this->getUser());
                $em->persist($st);
            }
            $em->persist($classDnD);
            $em->flush();
                    
            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la classe a bien été mise à jour.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
        }
        
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:editST.html.twig', array(
                                'classDnD' => $classDnD,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $classDnD = $this->getDoctrine()->getManager()->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $deleteClassDnD = $this->container->get('dndrules_character.deleteclassdnd');
        $deleteClassDnD->deleteClassDnD($classDnD);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre classe a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_classdnd_classdnd_home');
    }
}
