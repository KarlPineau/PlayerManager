<?php

namespace DnDRules\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SortBundle\Entity\Sort;
use DnDRules\SortBundle\Form\SortRegisterType;
use DnDRules\SortBundle\Form\SortEditType;

class SortController extends Controller
{
    public function indexAction()
    {
        $listSorts = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Sort')->findAll();
        return $this->render('DnDRulesSortBundle:Sort:index.html.twig', array(
            'listSorts' => $listSorts,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $sort = new Sort;
        
        $form = $this->createForm(new SortRegisterType, $sort);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $sort->setCreateUser($this->getUser());
                    // -- Gestion de la classe
                    $classes = $sort->getClasses();
                    foreach ($classes as $class) {
                        $class->setCreateUser($this->getUser());
                        $class->setSort($sort);
                        $em->persist($class);
                    }
                    // -- Gestion du domain
                    $domains = $sort->getDomains();
                    foreach ($domains as $domain) {
                        $domain->setCreateUser($this->getUser());
                        $domain->setSort($sort);
                        $em->persist($domain);
                    }
                    
                    $em->persist($sort);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le sort a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_sort_view', array('slug' => $sort->getSlug())));
                }
            }
        return $this->render('DnDRulesSortBundle:Sort:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $sort = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Sort')->findOneBySlug($slug);
        if ($sort === null) {throw $this->createNotFoundException('Sort : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesSortBundle:Sort:view.html.twig', array(
                                'sort' => $sort,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $sort = $em->getRepository('DnDRulesSortBundle:Sort')->findOneBySlug($slug);
        if ($sort === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Sort : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new SortEditType, $sort);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $sort->setUpdateUser($this->getUser());
                    $em->persist($sort);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre sort a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_sort_view', array('slug' => $sort->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSortBundle:Sort:Edit/edit.html.twig', array(
                                'sort' => $sort,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $sort = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Sort')->findOneBySlug($slug);
        if($sort === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Sort : [slug='.$slug.'] inexistant.');}
        
        $sortAction = $this->container->get('dndrules_sort.sortaction');
        $sortAction->deleteSort($sort);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre sort a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_sort_sort_home');
    }
}
