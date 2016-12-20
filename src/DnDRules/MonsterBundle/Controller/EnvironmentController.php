<?php

namespace DnDRules\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Environment;
use DnDRules\MonsterBundle\Form\EnvironmentRegisterType;
use DnDRules\MonsterBundle\Form\EnvironmentEditType;

class EnvironmentController extends Controller
{
    public function indexAction()
    {
        $listEnvironments = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Environment')->findAll();
        return $this->render('DnDRulesMonsterBundle:Environment:index.html.twig', array(
            'listEnvironments' => $listEnvironments,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $environment = new Environment;
        
        $form = $this->createForm(new EnvironmentRegisterType, $environment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $environment->setCreateUser($this->getUser());
                    $em->persist($environment);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'environnement a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_environment_view', array('slug' => $environment->getSlug())));
                }
            }
        return $this->render('DnDRulesMonsterBundle:Environment:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $environment = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Environment')->findOneBySlug($slug);
        if ($environment === null) {throw $this->createNotFoundException('Environment : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesMonsterBundle:Environment:view.html.twig', array(
                                'environment' => $environment,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $environment = $em->getRepository('DnDRulesMonsterBundle:Environment')->findOneBySlug($slug);
        if($environment === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Environment : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new EnvironmentEditType, $environment);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $environment->setUpdateUser($this->getUser());
                    $em->persist($environment);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre environnement a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_environment_view', array('slug' => $environment->getSlug())));
                }
            }
        
        return $this->render('DnDRulesMonsterBundle:Environment:Edit/edit.html.twig', array(
                                'environment' => $environment,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $environment = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Environment')->findOneBySlug($slug);
        if($environment === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Environment : [slug='.$slug.'] inexistant.');}
        
        $environmentAction = $this->container->get('dndrules_monster.environmentaction');
        $environmentAction->deleteEnvironment($environment);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre environnement a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_environment_home');
    }
}
