<?php

namespace DnDRules\ClassDnDBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class classDnDAction
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function getSortsByLevel($classDnD, $level) {
        $sorts = array();
        $repository = $this->em->getRepository('DnDRulesSortBundle:SortClassDnD');
        $sortClasses = $repository->findBy(array('classdnd' => $classDnD, 'minimumLevel' => $level));
        foreach ($sortClasses as $sortClass) {
            array_push($sorts, $sortClass->getSort());
        }
        return $sorts;
    }
    
    public function getSorts($classDnD) {
        $sorts = array();
        $repositoryLevel = $this->em->getRepository('DnDRulesLevelBundle:Level');
        $levels = $repositoryLevel->findBy(array(), array('level' => 'asc'));
        foreach ($levels as $level) {
            $levelArray = array();
            array_push($levelArray, $level);
            array_push($levelArray, $this->getSortsByLevel($classDnD, $level));
            array_push($sorts, $levelArray);
        }
        return $sorts;
    }
}
