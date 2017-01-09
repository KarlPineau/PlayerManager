<?php

namespace PM\AdministrationBundle\Controller;

use DnDRules\RaceBundle\Entity\RaceLevel;
use DnDRules\RaceBundle\Entity\RaceST;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MajController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        foreach($em->getRepository('DnDRulesRaceBundle:Race')->findAll() as $race) {
            if($em->getRepository('DnDRulesRaceBundle:RaceST')->findOneByRace($race) == null) {
                $raceST = new RaceST();
                $raceST->setRace($race);
                $raceST->setFortitude(0);
                $raceST->setReflex(0);
                $raceST->setWill(0);
                $em->persist($raceST);
            }

            foreach($em->getRepository('DnDRulesLevelBundle:Level')->findAll() as $level) {
                if($em->getRepository('DnDRulesRaceBundle:RaceLevel')->findOneBy(array('race' => $race, 'level' => $level)) == null) {
                    $raceLevel = new RaceLevel();
                    $raceLevel->setRace($race);
                    $raceLevel->setLevel($level);
                    $raceLevel->setGift(false);
                    $raceLevel->setAdditionalSkillPoints(0);
                    $em->persist($raceLevel);
                }
            }
        }

        $em->flush();

        return $this->redirectToRoute('pm_administration_home_index');
    }
}
