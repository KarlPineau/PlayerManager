<?php

namespace DnDRules\ClassDnDBundle\Controller;

use DnDRules\ClassDnDBundle\Entity\ClassDnDLevel;
use DnDRules\ClassDnDBundle\Form\BAB\ClassDnDForBABType;
use DnDRules\ClassDnDBundle\Form\Sort\ClassDnDForSortType;
use DnDRules\ClassDnDBundle\Form\ST\ClassDnDForSTType;
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
    
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $classDnD = new ClassDnD;
        
        $form = $this->createForm(new ClassDnDRegisterType, $classDnD);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classDnD->setCreateUser($this->getUser());
            $em->persist($classDnD);
            $em->flush();
            $this->get('dndrules_classdnd.classdndaction')->generateLevel($classDnD);

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la classe a bien été créée.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
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
        
        $classDnDLevels = $repositoryClassDnDLevel->getByClassDnD($classDnD);
                    //findBy(array('classDnD' => $classDnD), array('level' => 'asc'));
        
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
    
    public function editAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new ClassDnDEditType, $classDnD);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classDnD->setUpdateUser($this->getUser());
            $em->persist($classDnD);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
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

        $form = $this->createForm(new ClassDnDForBABType(), $classDnD);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classDnD->setUpdateUser($this->getUser());

            foreach($classDnD->getLevels() as $classDnDLevel) {
                foreach($classDnDLevel->getClassBABs() as $classBAB) {
                    $classBAB->setClassDnDLevelBABs($classDnDLevel);
                    $em->persist($classBAB);
                }
                $em->persist($classDnDLevel);
            }

            $em->persist($classDnD);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
        }

        return $this->render('DnDRulesClassDnDBundle:ClassDnD:BAB/edit.html.twig', array(
                                'classDnD' => $classDnD,
                                'form' => $form->createView(),
                            ));
    }
    
    public function editSTAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}

        $form = $this->createForm(new ClassDnDForSTType(), $classDnD);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classDnD->setUpdateUser($this->getUser());

            foreach($classDnD->getLevels() as $classDnDLevel) {
                foreach($classDnDLevel->getClassST() as $classST) {
                    $classST->setClassDnDLevelST($classDnDLevel);
                    $em->persist($classST);
                }
                $em->persist($classDnDLevel);
            }

            $em->persist($classDnD);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
        }

        return $this->render('DnDRulesClassDnDBundle:ClassDnD:ST/edit.html.twig', array(
            'classDnD' => $classDnD,
            'form' => $form->createView(),
        ));
    }

    public function editSortAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}

        $form = $this->createForm(new ClassDnDForSortType(), $classDnD);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classDnD->setUpdateUser($this->getUser());

            foreach($classDnD->getLevels() as $classDnDLevel) {
                foreach($classDnDLevel->getClassSorts() as $classSort) {
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

        return $this->render('DnDRulesClassDnDBundle:ClassDnD:Sort/edit.html.twig', array(
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

    public function generateLevelAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneBySlug($slug);
        if ($classDnD === null) {throw $this->createNotFoundException('Classe : [slug='.$slug.'] inexistante.');}

        $count = $this->get('dndrules_classdnd.classdndaction')->generateLevel($classDnD);
        $this->get('session')->getFlashBag()->add('notice', $count.' niveaux ont été générés' );
        return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
    }
}
