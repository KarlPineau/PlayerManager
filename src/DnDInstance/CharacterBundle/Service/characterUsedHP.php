<?php

namespace DnDInstance\CharacterBundle\Service;

use DnDInstance\ArmorBundle\Entity\ArmorInstance;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use \DnDInstance\CharacterBundle\Entity\XpPoints;
use \DnDRules\WeaponBundle\Entity\Weapon;

class characterUsedHP
{
    protected $em;
    protected $security;
    protected $characterusedability;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context, CharacterUsedAbility $characterusedability)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
        $this->characterusedability = $characterusedability;
    }
    
    /*
     * Chaque classe offre des DV d'une taille déterminé, indiquée dans la description technique de la classe en
     * question ; le personnage possède autant de DV de cette taille que de niveau(x) dans la classe considérée.
     *
     * Pour déterminer son nombre de PV, il faut effectuer un jet avec chacun des DV possédés et ajouter à chaque
     * lancer le modificateur de Constitution du personnage.
     *
     * Supposons enfin que notre personnage possède une Constitution de 16 (soit un modificateur de +3). Ses DV sont
     * les suivants : 5d10 (guerrier 5) + 4d6 (magicien 4) + 3d8 (prêtre 3) + 2d8 (roublard 2). Ses PV seront donc
     * quant à eux déterminés par le résultat du tirage de 5d10+5d8+4d6 auquel on ajoutera 42 (14 x modificateur
     * de Constitution)
     */
}
