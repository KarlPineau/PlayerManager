<?php

namespace PM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MajController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        foreach($em->getRepository('DnDInstanceCharacterBundle:CharacterWealth')->findAll() as $wealth) {
            if($wealth->getCharacterUsedWealth() == null) {
                $wealth->setCharacterUsedWealth($em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($wealth->getId()));
                $em->persist($wealth);
            }
        }


        foreach($em->getRepository('GameGameBundle:Game')->findAll() as $game) {
            $this->get('session')->getFlashBag()->add('notice', $game->getName());
            foreach($game->getCharacters() as $characterUsed) {
                $characterUsed->setGame($game);
                $em->persist($characterUsed);
                $this->get('session')->getFlashBag()->add('notice', 'Match');
            }
        }

        $em->flush();

        return $this->redirectToRoute('pm_administration_home_index');
    }
}
