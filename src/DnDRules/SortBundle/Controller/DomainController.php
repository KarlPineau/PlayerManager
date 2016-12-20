<?php

namespace DnDRules\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SortBundle\Entity\Domain;
use DnDRules\SortBundle\Form\DomainRegisterType;
use DnDRules\SortBundle\Form\DomainEditType;

class DomainController extends Controller
{
    public function indexAction()
    {
        $listDomains = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Domain')->findAll();
        return $this->render('DnDRulesSortBundle:Domain:index.html.twig', array(
            'listDomains' => $listDomains,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $domain = new Domain;
        
        $form = $this->createForm(new DomainRegisterType, $domain);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $domain->setCreateUser($this->getUser());
                    $em->persist($domain);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la domain a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_domain_view', array('slug' => $domain->getSlug())));
                }
            }
        return $this->render('DnDRulesSortBundle:Domain:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $domain = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Domain')->findOneBySlug($slug);
        if($domain === null) {throw $this->createNotFoundException('Domain : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesSortBundle:Domain:view.html.twig', array(
                                'domain' => $domain,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $domain = $em->getRepository('DnDRulesSortBundle:Domain')->findOneBySlug($slug);
        if ($domain === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Domain : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new DomainEditType, $domain);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $domain->setUpdateUser($this->getUser());
                    $em->persist($domain);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre domain a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_domain_view', array('slug' => $domain->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSortBundle:Domain:Edit/edit.html.twig', array(
                                'domain' => $domain,
                                'form' => $form->createView(),
                            ));
    }

    public function deleteAction($slug)
    {
        $domain = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Domain')->findOneBySlug($slug);
        if($domain === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Domain : [slug='.$slug.'] inexistant.');}
        
        $domainAction = $this->container->get('dndrules_sort.domainaction');
        $domainAction->deleteDomain($domain);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre domain a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_sort_domain_home');
    }
}
