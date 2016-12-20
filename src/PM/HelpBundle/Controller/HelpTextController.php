<?php

namespace PM\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PM\HelpBundle\Entity\HelpText;
use PM\HelpBundle\Form\HelpTextRegisterType;
use PM\HelpBundle\Form\HelpTextEditType;

class HelpTextController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMHelpBundle:HelpText:index.html.twig');
    }
    
    public function registerAction()
    {
        $current_user = $this->getUser();
        $helptext = new HelpText;
        $helptext->setCreateUser($current_user);
        
        $form = $this->createForm(new HelpTextRegisterType, $helptext);
 
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($helptext);
                    
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre aide a bien été créée.' );
                    return $this->redirect($this->generateUrl('pm_helptext_administration_view', array('id' => $helptext->getId())));
                }
            }
        return $this->render('PMHelpBundle:HelpText:register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHelpBundle:HelpText');
 
        $helptext = $repository->findOneById($id);
        
        if ($helptext === null) {
          throw $this->createNotFoundException('Aide : [id='.$id.'] inexistante.');
        }
        
        return $this->render('PMHelpBundle:HelpText:view.html.twig', array(
                                'helptext' => $helptext,
                            ));
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PMHelpBundle:HelpText');
 
        $helptext = $repository->findOneById($id);
        
        if ($helptext === null) {
          throw $this->createNotFoundException('Aide : [id='.$id.'] inexistante.');
        }
        
        $form = $this->createForm(new HelpTextEditType, $helptext);
        
        $current_user = $this->getUser();
        $helptext->setUpdateUser($current_user);
        
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($helptext);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre aide a bien été éditée.' );
                    return $this->redirect($this->generateUrl('pm_helptext_administration_view', array('id' => $helptext->getId())));
                }
            }
        
        return $this->render('PMHelpBundle:HelpText:edit.html.twig', array(
                                'helptext' => $helptext,
                                'form' => $form->createView(),
                            ));
    }
    
    public function listAction()
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHelpBundle:HelpText');
 
        $listHelpTexts = $repository->findAll();

        return $this->render('PMHelpBundle:HelpText:listHelpTexts.html.twig', array(
                                'listHelpTexts' => $listHelpTexts,
                            ));
    }
    
    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHelpBundle:HelpText');
        $helptext = $repository->findOneById($id);
        
        if ($helptext === null) {
          throw $this->createNotFoundException('Aide : [id='.$id.'] inexistante.');
        }
        
        $deleteHelpText = $this->container->get('pm_helptext.deletehelptext');
        $deleteHelpText->deleteHelpText($helptext);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre aide a bien été supprimée.' );
        return $this->forward('PMHelpBundle:HelpText:list');
    }
}
