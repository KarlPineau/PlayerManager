<?php

namespace PM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMAdministrationBundle:Home:index.html.twig');
    }
}
