<?php

namespace PM\HelpBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class deleteHelpText 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteHelpText($helptext)
    {
        /* A supprimer avec une taille :
         *  -> HelpText : Entité Caractéristique
         *  -> A voir pour le reste
         */
        
        $this->em->remove($helptext);
        $this->em->flush();
    }
}
