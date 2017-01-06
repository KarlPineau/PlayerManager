<?php

namespace DnDInstance\EquipmentBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class equipmentInstance
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }

    public function cloneEquipmentInstance($equipmentInstance, $characterUsedDnDInstance)
    {
        $newEquipmentInstance = clone $equipmentInstance;
        $newEquipmentInstance->setCharacterUsedEquipments($characterUsedDnDInstance);
        $newEquipmentInstance->setId(null);

        $this->em->persist($newEquipmentInstance);
        $this->em->flush();

        return $newEquipmentInstance;
    }
}
