<?php

namespace DnDInstance\CharacterBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class characterUsedWealth
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }

    public function findByCharacterUsed($characterUsed)
    {
        return $this->em->getRepository('DnDInstanceCharacterBundle:CharacterWealth')->findOneBy(array('characterUsedWealth' => $characterUsed));
    }

    public function cloneWealth($characterWealth, $characterUsed)
    {
        $newCharacterWealth = clone $characterWealth;
        $newCharacterWealth->setId(null);

        $characterUsed->setWealth($newCharacterWealth);

        $this->em->persist($newCharacterWealth);
        $this->em->flush();

        return $newCharacterWealth;
    }
}
