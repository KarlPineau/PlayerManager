<?php

namespace DnDInstance\ClassDnDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DnDInstanceClassDnDBundle:Default:index.html.twig', array('name' => $name));
    }
}
