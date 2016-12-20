<?php

namespace DnDRules\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SortBundle\Entity\Composante;
use DnDRules\SortBundle\Form\ComposanteRegisterType;
use DnDRules\SortBundle\Form\ComposanteEditType;

class ComposanteController extends Controller
{
    public function indexAction()
    {
        $listComposantes = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Composante')->findAll();
        return $this->render('DnDRulesSortBundle:Composante:index.html.twig', array(
            'listComposantes' => $listComposantes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $composante = new Composante;
        
        $form = $this->createForm(new ComposanteRegisterType, $composante);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $composante->setCreateUser($this->getUser());
                    $em->persist($composante);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la composante a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_composante_view', array('slug' => $composante->getSlug())));
                }
            }
        return $this->render('DnDRulesSortBundle:Composante:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $composante = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Composante')->findOneBySlug($slug);
        if($composante === null) {throw $this->createNotFoundException('Composante : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesSortBundle:Composante:view.html.twig', array(
                                'composante' => $composante,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $composante = $em->getRepository('DnDRulesSortBundle:Composante')->findOneBySlug($slug);
        if($composante === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Composante : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new ComposanteEditType, $composante);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $composante->setUpdateUser($this->getUser());
                    $em->persist($composante);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre composante a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_sort_composante_view', array('slug' => $composante->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSortBundle:Composante:Edit/edit.html.twig', array(
                                'composante' => $composante,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $composante = $this->getDoctrine()->getManager()->getRepository('DnDRulesSortBundle:Composante')->findOneBySlug($slug);
        if ($composante === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Composante : [slug='.$slug.'] inexistant.');}
        
        $composanteAction = $this->container->get('dndrules_sort.composanteaction');
        $composanteAction->deleteComposante($composante);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre composante a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_sort_composante_home');
    }
}
