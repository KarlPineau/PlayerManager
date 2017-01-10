<?php

namespace DnDInstance\SortBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class sortInstance
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }

    public function cloneSortInstance($sortInstance, $characterUsedDnDInstance)
    {
        $newSortInstance = clone $sortInstance;
        $newSortInstance->setCharacterUsed($characterUsedDnDInstance);
        $newSortInstance->setId(null);

        $this->em->persist($newSortInstance);
        $this->em->flush();

        return $newSortInstance;
    }

    public function getSorts($characterUsed)
    {
        return $this->em->getRepository('DnDInstanceSortBundle:SortInstance')->findByCharacterUsed($characterUsed);
    }
}
