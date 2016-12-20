<?php

namespace PM\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $listCharactersUsed = $repositoryCharacterUsed->findByUser($this->getUser());

        $repositoryGame = $em->getRepository('GameGameBundle:Game');
        $listGamesPlayer = $repositoryGame->findMyGamesByCharacter($this->getUser());
        $listGamesMaster = $repositoryGame->findMyGamesByGameMaster($this->getUser());

        $listGames = array_merge($listGamesPlayer, $listGamesMaster);

        return $this->render('PMHomeBundle:Home:index.html.twig', array(
            'listGames' => $listGames,
            'listCharactersUsed' => $listCharactersUsed,
        ));
    }
}
