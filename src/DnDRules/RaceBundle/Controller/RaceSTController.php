<?php

namespace DnDRules\RaceBundle\Controller;

use DnDRules\RaceBundle\Entity\RaceST;
use DnDRules\RaceBundle\Form\RaceSTType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaceSTController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $race = $em->getRepository('DnDRulesRaceBundle:Race')->findOneById($id);
        if($race === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Race : [slug='.$slug.'] inexistante.');}

        $raceST = $em->getRepository('DnDRulesRaceBundle:RaceST')->findOneByRace($race);
        if($raceST === null) {
            $raceST = new RaceST();
            $raceST->setRace($race);
        }

        $form = $this->createForm(new RaceSTType(), $raceST);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($raceST);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les bonus aux Jets de Sauvegarde de votre race ont bien été édités.' );
            return $this->redirect($this->generateUrl('dndrules_race_race_view', array('slug' => $race->getSlug())));
        }
        
        return $this->render('DnDRulesRaceBundle:Race:ST/edit.html.twig', array(
                                'race' => $race,
                                'form' => $form->createView(),
                            ));
    }
}
