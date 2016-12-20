<?php

namespace DnDRules\LanguageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\LanguageBundle\Entity\Language;
use DnDRules\LanguageBundle\Form\LanguageRegisterType;
use DnDRules\LanguageBundle\Form\LanguageEditType;

class LanguageController extends Controller
{
    public function indexAction()
    {
        $listLanguages = $this->getDoctrine()->getManager()->getRepository('DnDRulesLanguageBundle:Language')->findAll();
        return $this->render('DnDRulesLanguageBundle:Language:index.html.twig', array(
            'listLanguages' => $listLanguages,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $language = new Language;
        
        $form = $this->createForm(new LanguageRegisterType, $language);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $language->setCreateUser($this->getUser());
                    $em->persist($language);
                    
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la langue a bien été créée.' );
           
                    return $this->redirect($this->generateUrl('dndrules_language_language_view', array('slug' => $language->getSlug())));
                }
            }
        return $this->render('DnDRulesLanguageBundle:Language:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $language = $this->getDoctrine()->getManager()->getRepository('DnDRulesLanguageBundle:Language')->findOneBySlug($slug);
        if($language === null) {throw $this->createNotFoundException('Langue : [slug='.$slug.'] inexistante.');}
        
        return $this->render('DnDRulesLanguageBundle:Language:view.html.twig', array(
                                'language' => $language,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $language = $em->getRepository('DnDRulesLanguageBundle:Language')->findOneBySlug($slug);
        if ($language === null OR !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Langue : [slug='.$slug.'] inexistante.');}
        
        $form = $this->createForm(new LanguageEditType, $language);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $language->setUpdateUser($this->getUser());
                    $em->persist($language);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre langue a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_language_language_view', array('slug' => $language->getSlug())));
                }
            }
        
        return $this->render('DnDRulesLanguageBundle:Language:Edit/edit.html.twig', array(
                                'language' => $language,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $language = $this->getDoctrine()->getManager()->getRepository('DnDRulesLanguageBundle:Language')->findOneBySlug($slug);
        if ($language === null OR !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Langue : [slug='.$slug.'] inexistante.');}
        
        $deleteLanguage = $this->container->get('dndrules_language.deletelanguage');
        $deleteLanguage->deleteLanguage($language);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre langue a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_language_language_home');
    }
}
