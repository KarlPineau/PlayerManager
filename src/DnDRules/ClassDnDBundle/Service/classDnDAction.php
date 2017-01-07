<?php

namespace DnDRules\ClassDnDBundle\Service;

use DnDRules\ClassDnDBundle\Entity\ClassDnDLevel;
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

    public function getSortsForLevelMaxByLevel($classDnD, $levelMax) {
        $sorts = array();
        $repositoryLevel = $this->em->getRepository('DnDRulesLevelBundle:Level');
        $levels = $repositoryLevel->findBy(array(), array('level' => 'asc'));
        foreach ($levels as $level) {
            if($level->getLevel() <= $levelMax) {
                array_push($sorts, $this->getSortsByLevel($classDnD, $level));
            }
        }
        return $sorts;
    }

    public function getSortsForLevelMax($classDnD, $levelMax) {
        $sorts = array();
        $repositoryLevel = $this->em->getRepository('DnDRulesLevelBundle:Level');
        $levels = $repositoryLevel->findBy(array(), array('level' => 'asc'));
        foreach ($levels as $level) {
            if($level->getLevel() <= $levelMax) {
                $sorts = array_merge($sorts, $this->getSortsByLevel($classDnD, $level));
            }
        }
        return $sorts;
    }

    public function generateLevel($classDnD) {
        $count = 0;
        foreach($this->em->getRepository('DnDRulesLevelBundle:Level')->findAll() as $level) {
            if($this->em->getRepository('DnDRulesClassDnDBundle:ClassDnDLevel')->findOneBy(array('classDnD' => $classDnD, 'level' => $level)) == null) {
                $classDnDLevel = new ClassDnDLevel();
                $classDnDLevel->setClassDnD($classDnD);
                $classDnDLevel->setLevel($level);
                $this->em->persist($classDnDLevel);
                $count++;
            }
        }

        $this->em->flush();
        return $count;
    }
}
