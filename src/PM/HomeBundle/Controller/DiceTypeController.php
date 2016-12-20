<?php

namespace PM\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PM\HomeBundle\Entity\DiceType;
use PM\HomeBundle\Form\DiceTypeRegisterType;
use PM\HomeBundle\Form\DiceTypeEditType;

class DiceTypeController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMHomeBundle:DiceType:index.html.twig');
    }
    
    public function registerAction()
    {
        $current_user = $this->getUser();
        $dicetype = new DiceType;
        $dicetype->setCreateUser($current_user);
        
        $form = $this->createForm(new DiceTypeRegisterType, $dicetype);
 
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($dicetype);
                    
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre caractéristique a bien été créée.' );
                    return $this->redirect($this->generateUrl('pm_dicetype_administration_view', array('dicetype_id' => $dicetype->getId())));
                }
            }
        return $this->render('PMHomeBundle:DiceType:register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($dicetype_id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHomeBundle:DiceType');
 
        $dicetype = $repository->findOneById($dicetype_id);
        
        if ($dicetype === null) {
          throw $this->createNotFoundException('Caractéristique : [dicetype_id='.$dicetype_id.'] inexistante.');
        }
        
        return $this->render('PMHomeBundle:DiceType:view.html.twig', array(
                                'dicetype' => $dicetype,
                            ));
    }
    
    public function editAction($dicetype_id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PMHomeBundle:DiceType');
 
        $dicetype = $repository->findOneById($dicetype_id);
        
        if ($dicetype === null) {
          throw $this->createNotFoundException('Caractéristique : [dicetype_id='.$dicetype_id.'] inexistante.');
        }
        
        $form = $this->createForm(new DiceTypeEditType, $dicetype);
        
        $current_user = $this->getUser();
        $dicetype->setUpdateUser($current_user);
        
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $em->persist($dicetype);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre caractéristique a bien été éditée.' );
                    return $this->redirect($this->generateUrl('pm_dicetype_administration_view', array('dicetype_id' => $dicetype->getId())));
                }
            }
        
        return $this->render('PMHomeBundle:DiceType:edit.html.twig', array(
                                'dicetype' => $dicetype,
                                'form' => $form->createView(),
                            ));
    }
    
    public function listAction()
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHomeBundle:DiceType');
 
        $listDiceTypes = $repository->findAll();

        return $this->render('PMHomeBundle:DiceType:listDiceTypes.html.twig', array(
                                'listDiceTypes' => $listDiceTypes,
                            ));
    }
    
    public function deleteAction($dicetype_id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHomeBundle:DiceType');
        $dicetype = $repository->findOneById($dicetype_id);
        
        if ($dicetype === null) {
          throw $this->createNotFoundException('Caractéristique : [dicetype_id='.$dicetype_id.'] inexistante.');
        }
        
        $deleteDiceType = $this->container->get('pm_character.deletedicetype');
        $deleteDiceType->deleteDiceType($dicetype);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre caractéristique a bien été supprimée.' );
        return $this->forward('PMHomeBundle:DiceType:list');
    }
}
