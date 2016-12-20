<?php

namespace DnDRules\SizeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SizeBundle\Entity\Size;
use DnDRules\SizeBundle\Form\SizeRegisterType;
use DnDRules\SizeBundle\Form\SizeEditType;

class SizeController extends Controller
{
    public function indexAction()
    {
        $listSizes = $this->getDoctrine()->getManager()->getRepository('DnDRulesSizeBundle:Size')->findAll();
        return $this->render('DnDRulesSizeBundle:Size:index.html.twig', array(
            'listSizes' => $listSizes,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $size = new Size;
        
        $form = $this->createForm(new SizeRegisterType, $size);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $size->setCreateUser($this->getUser());
                    $em->persist($size);
                    
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre taille a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_size_size_view', array('slug' => $size->getSlug())));
                }
            }
        return $this->render('DnDRulesSizeBundle:Size:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $size = $this->getDoctrine()->getManager()->getRepository('DnDRulesSizeBundle:Size')->findOneBySlug($slug);
        if ($size === null) {throw $this->createNotFoundException('Taille : [slug='.$slug.'] inexistante.');}
        
        return $this->render('DnDRulesSizeBundle:Size:view.html.twig', array(
                                'size' => $size,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $size = $em->getRepository('DnDRulesSizeBundle:Size')->findOneBySlug($slug);
        if ($size === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Taille : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new SizeEditType, $size);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $size->setUpdateUser($this->getUser());
                    $em->persist($size);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre taille a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_size_size_view', array('slug' => $size->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSizeBundle:Size:Edit/edit.html.twig', array(
                                'size' => $size,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $size = $this->getDoctrine()->getManager()->getRepository('DnDRulesSizeBundle:Size')->findOneBySlug($slug);
        if ($size === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Taille : [slug='.$slug.'] inexistante.');}
        
        $deleteSize = $this->container->get('dndrules_size.deletesize');
        $deleteSize->deleteSize($size);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre taille a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_size_size_home');
    }
}
