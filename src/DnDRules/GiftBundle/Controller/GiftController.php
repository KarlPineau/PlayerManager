<?php

namespace DnDRules\GiftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\GiftBundle\Entity\Gift;
use DnDRules\GiftBundle\Form\GiftRegisterType;
use DnDRules\GiftBundle\Form\GiftEditType;

class GiftController extends Controller
{
    public function indexAction()
    {
        $listGifts = $this->getDoctrine()->getManager()->getRepository('DnDRulesGiftBundle:Gift')->findAll();

        return $this->render('DnDRulesGiftBundle:Gift:index.html.twig', array(
            'listGifts' => $listGifts,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $gift = new Gift;
        $form = $this->createForm(new GiftRegisterType, $gift);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $gift->setCreateUser($this->getUser());
                    $em->persist($gift);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le don a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_gift_gift_view', array('slug' => $gift->getSlug())));
                }
            }
        return $this->render('DnDRulesGiftBundle:Gift:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $gift = $this->getDoctrine()->getManager()->getRepository('DnDRulesGiftBundle:Gift')->findOneBySlug($slug);
        if($gift === null) {throw $this->createNotFoundException('Gift : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesGiftBundle:Gift:view.html.twig', array(
                                'gift' => $gift,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $gift = $em->getRepository('DnDRulesGiftBundle:Gift')->findOneBySlug($slug);
        if ($gift === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Gift : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new GiftEditType, $gift);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $gift->setUpdateUser($this->getUser());
                    $em->persist($gift);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre don a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_gift_gift_view', array('slug' => $gift->getSlug())));
                }
            }
        
        return $this->render('DnDRulesGiftBundle:Gift:Edit/edit.html.twig', array(
                                'gift' => $gift,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $gift = $this->getDoctrine()->getManager()->getRepository('DnDRulesGiftBundle:Gift')->findOneBySlug($slug);
        if ($gift === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Gift : [slug='.$slug.'] inexistant.');}
        
        $giftAction = $this->container->get('dndrules_gift.giftaction');
        $giftAction->deleteGift($gift);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre don a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_gift_gift_home');
    }
}
