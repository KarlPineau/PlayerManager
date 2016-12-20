<?php

namespace DnDRules\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SortBundle\Entity\SortSchool;
use DnDRules\SortBundle\Form\SortSchoolRegisterType;
use DnDRules\SortBundle\Form\SortSchoolEditType;

class SortSchoolController extends Controller
{
    public function indexAction()
    {
        $listSortSchools = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:SortSchool')->findAll();
        return $this->render('DnDRulesSortBundle:SortSchool:index.html.twig', array(
            'listSortSchools' => $listSortSchools,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $sortschool = new SortSchool;

        $form = $this->createForm(new SortSchoolRegisterType, $sortschool);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $sortschool->setCreateUser($this->getUser());
                    $em->persist($sortschool);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la sortschool a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_sortschool_view', array('slug' => $sortschool->getSlug())));
                }
            }
        return $this->render('DnDRulesSortBundle:SortSchool:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $sortschool = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:SortSchool')->findOneBySlug($slug);
        if ($sortschool === null) {throw $this->createNotFoundException('SortSchool : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesSortBundle:SortSchool:view.html.twig', array(
                                'sortschool' => $sortschool,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $sortschool = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:SortSchool')->findOneBySlug($slug);
        if ($sortschool === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('SortSchool : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new SortSchoolEditType, $sortschool);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $sortschool->setUpdateUser($this->getUser());
                    $em->persist($sortschool);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre sortschool a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_sortschool_view', array('slug' => $sortschool->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSortBundle:SortSchool:Edit/edit.html.twig', array(
                                'sortschool' => $sortschool,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $sortschool = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:SortSchool')->findOneBySlug($slug);
        if($sortschool === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('SortSchool : [slug='.$slug.'] inexistant.');}
        
        $sortschoolAction = $this->container->get('dndrules_sort.sortschoolaction');
        $sortschoolAction->deleteSortSchool($sortschool);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre sortschool a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_sort_sortschool_home');
    }
}
