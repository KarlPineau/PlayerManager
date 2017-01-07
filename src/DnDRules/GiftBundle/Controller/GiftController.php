<?php

namespace DnDRules\GiftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\GiftBundle\Entity\Gift;
use DnDRules\GiftBundle\Form\GiftRegisterType;
use DnDRules\GiftBundle\Form\GiftEditType;
use Symfony\Component\HttpFoundation\Request;

class GiftController extends Controller
{
    public function indexAction()
    {
        $listGifts = $this->getDoctrine()->getManager()->getRepository('DnDRulesGiftBundle:Gift')->findAll();

        return $this->render('DnDRulesGiftBundle:Gift:index.html.twig', array(
            'listGifts' => $listGifts,
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
    
    public function editAction($id=null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($id != null) {
            $gift = $em->getRepository('DnDRulesGiftBundle:Gift')->findOneById($id);
            if($gift === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Gift [id='.$id.'] undefined.');}
        } else {
            $gift = new Gift();
            $gift->setCreateUser($this->getUser());
        }
        
        $form = $this->createForm(new GiftEditType, $gift);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gift->setUpdateUser($this->getUser());
            $em->persist($gift);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre don a bien été édité.' );
            return $this->redirect($this->generateUrl('dndrules_gift_gift_view', array('slug' => $gift->getSlug())));
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
