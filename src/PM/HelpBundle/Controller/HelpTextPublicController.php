<?php

namespace PM\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelpTextPublicController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMHelpBundle:HelpTextPublic:index.html.twig');
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHelpBundle:HelpText');
 
        $HelpText = $repository->findOneById($id);
        
        if ($HelpText === null) {
          throw $this->createNotFoundException('Caractéristique : [id='.$id.'] inexistante.');
        }
        
        return $this->render('PMHelpBundle:HelpTextPublic:view.html.twig', array(
                                'HelpText' => $HelpText,
                            ));
    }
    
    public function listAction()
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMHelpBundle:HelpText');
 
        $listAbilities = $repository->findAll();

        return $this->render('PMHelpBundle:HelpTextPublic:listAbilities.html.twig', array(
                                'listAbilities' => $listAbilities,
                            ));
    }
}
