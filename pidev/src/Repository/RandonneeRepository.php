<?php

namespace App\Repository;

use App\Entity\randonnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method randonnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method randonnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method randonnee[]    findAll()
 * @method randonnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandonneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, randonnee::class);
    }

    // /**
    //  * @return randonnee[] Returns an array of randonnee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?randonnee
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
