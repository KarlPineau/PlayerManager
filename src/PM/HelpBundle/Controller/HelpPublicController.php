<?php

namespace PM\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelpPublicController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMHelpBundle:HelpPublic:index.html.twig');
    }
}
