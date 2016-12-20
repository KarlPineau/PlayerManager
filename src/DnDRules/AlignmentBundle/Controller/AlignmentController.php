<?php

namespace DnDRules\AlignmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\AlignmentBundle\Entity\Alignment;
use DnDRules\AlignmentBundle\Form\AlignmentRegisterType;
use DnDRules\AlignmentBundle\Form\AlignmentEditType;

class AlignmentController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DnDRulesAlignmentBundle:Alignment');

        $listAlignments = $repository->findAll();

        return $this->render('DnDRulesAlignmentBundle:Alignment:index.html.twig', array(
            'listAlignments' => $listAlignments,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}

        $alignment = new Alignment;
        $alignment->setCreateUser($this->getUser());
        
        $form = $this->createForm(new AlignmentRegisterType, $alignment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $em->persist($alignment);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'Alignement a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_alignment_alignment_view', array('slug' => $alignment->getSlug())));
                }
            }
        return $this->render('DnDRulesAlignmentBundle:Alignment:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $alignment = $this->getDoctrine()->getManager()->getRepository('DnDRulesAlignmentBundle:Alignment')->findOneBySlug($slug);
        if ($alignment === null) {throw $this->createNotFoundException('Alignement : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesAlignmentBundle:Alignment:view.html.twig', array(
                                'alignment' => $alignment,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $alignment = $em->getRepository('DnDRulesAlignmentBundle:Alignment')->findOneBySlug($slug);
        if ($alignment === null OR !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Alignement : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new AlignmentEditType, $alignment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $alignment->setUpdateUser($this->getUser());
                    $em->persist($alignment);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre alignement a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_alignment_alignment_view', array('slug' => $alignment->getSlug())));
                }
            }
        
        return $this->render('DnDRulesAlignmentBundle:Alignment:Edit/edit.html.twig', array(
                                'alignment' => $alignment,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $alignment = $this->getDoctrine()->getManager()->getRepository('DnDRulesAlignmentBundle:Alignment')->findOneBySlug($slug);
        if ($alignment === null OR !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Alignement : [slug='.$slug.'] inexistant.');}
        
        $deleteAlignment = $this->container->get('dndrules_character.deletealignment');
        $deleteAlignment->deleteAlignment($alignment);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre alignement a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_alignment_alignment_home');
    }
}
