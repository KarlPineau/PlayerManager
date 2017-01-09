<?php

namespace DnDRules\RaceBundle\Controller;

use DnDRules\RaceBundle\Entity\RaceLevels;
use DnDRules\RaceBundle\Form\RaceLevelsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaceLevelController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $race = $em->getRepository('DnDRulesRaceBundle:Race')->findOneById($id);
        if($race === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Race : [slug='.$slug.'] inexistante.');}

        $raceLevels = new RaceLevels();
        foreach($em->getRepository('DnDRulesRaceBundle:RaceLevel')->findByRace($race) as $raceLevel) {
            $raceLevels->addRaceLevel($raceLevel);
        }

        $form = $this->createForm(new RaceLevelsType(), $raceLevels);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($form->get('raceLevels')->getData() as $raceLevel) {
                $raceLevel->setRace($race);
                $em->persist($raceLevel);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les modificateurs de compétence de votre race ont bien été édités.' );
            return $this->redirect($this->generateUrl('dndrules_race_race_view', array('slug' => $race->getSlug())));
        }
        
        return $this->render('DnDRulesRaceBundle:Race:Level/edit.html.twig', array(
                                'race' => $race,
                                'form' => $form->createView(),
                            ));
    }
}
