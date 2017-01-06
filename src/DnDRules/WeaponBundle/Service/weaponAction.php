<?php

namespace DnDRules\WeaponBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class weaponAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteWeapon($weapon)
    {
        /* A supprimer avec un weapon :
         *  -> Weapon : Entité Weapon
         *  -> A voir pour le reste
         */
        
        $this->em->remove($weapon);
        $this->em->flush();
    }

    public function getDamagePerSize($weapon) {
        $weaponDamages = array();
        foreach($this->em->getRepository('DnDRulesSizeBundle:Size')->findAll() as $size) {
            if($this->em->getRepository('DnDRulesWeaponBundle:WeaponDamage')->findBy(array('weapon' => $weapon, 'size' => $size)) != null) {
                $weaponDamages[] = ['size' => $size, 'weapon' => $weapon, 'damages' => $this->em->getRepository('DnDRulesWeaponBundle:WeaponDamage')->findBy(array('weapon' => $weapon, 'size' => $size))];
            }
        }

        return $weaponDamages;
    }
}
