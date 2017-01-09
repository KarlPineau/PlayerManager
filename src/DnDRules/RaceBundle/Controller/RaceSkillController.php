<?php

namespace DnDRules\RaceBundle\Controller;

use DnDRules\RaceBundle\Entity\RaceSkills;
use DnDRules\RaceBundle\Form\RaceSkillsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaceSkillController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $race = $em->getRepository('DnDRulesRaceBundle:Race')->findOneById($id);
        if($race === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Race : [slug='.$slug.'] inexistante.');}

        $raceSkills = new RaceSkills();
        foreach($em->getRepository('DnDRulesRaceBundle:RaceSkill')->findByRace($race) as $raceSkill) {
            $raceSkills->addRaceSkill($raceSkill);
        }

        $form = $this->createForm(new RaceSkillsType(), $raceSkills);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($form->get('raceSkills')->getData() as $raceSkill) {
                $raceSkill->setRace($race);
                $em->persist($raceSkill);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les modificateurs de compétence de votre race ont bien été édités.' );
            return $this->redirect($this->generateUrl('dndrules_race_race_view', array('slug' => $race->getSlug())));
        }
        
        return $this->render('DnDRulesRaceBundle:Race:Skill/edit.html.twig', array(
                                'race' => $race,
                                'form' => $form->createView(),
                            ));
    }
}
