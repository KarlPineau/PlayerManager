<?php

namespace DnDRules\ClassDnDBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClassDnDLevelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClassDnDLevelRepository extends EntityRepository
{
    public function getByClassDnD($classDnD)
    {
        $query = $this->createQueryBuilder('cl')
                      ->innerJoin('cl.level', 'l')
                      ->where('cl.classDnD = :classDnD')
                      ->setParameter('classDnD', $classDnD)
                      ->orderBy('l.level', 'ASC')
                      ->getQuery()
                      ->getResult();

        return $query;
    }
}
