<?php

namespace CAS\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $repositoryUser = $this->getDoctrine()->getManager()->getRepository('CASUserBundle:User');
        $users = $repositoryUser->findAll();

        $paginator  = $this->get('knp_paginator');
        $listUsers = $paginator->paginate(
            $users,
            $request->query->get('page', 1)/*page number*/,
            100/*limit per page*/
        );

        return $this->render('CASAdministrationBundle:User:index.html.twig', array(
            'users' => $listUsers
        ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CASUserBundle:User')->findOneById($id);
        if ($user === null) { throw $this->createNotFoundException('User : [id='.$id.'] inexistant.'); }

        return $this->render('CASAdministrationBundle:User:view.html.twig', array(
            'user' => $user,
        ));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CASUserBundle:User')->findOneById($id);
        if($user === null) { throw $this->createNotFoundException('User : [id='.$id.'] inexistant.'); }

        $this->get('cas_user.remove')->remove($user);
        $em->flush();
        $this->get('session')->getFlashBag()->add('notice', 'L\'utilisateur a bien été supprimé');
        return $this->redirect($this->generateUrl('cas_administration_user_index'));
    }
}
