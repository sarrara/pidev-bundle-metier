<?php

namespace App\Repository;

use App\Entity\ReservationRon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationRon|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationRon|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationRon[]    findAll()
 * @method ReservationRon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationRon::class);
    }

    // /**
    //  * @return ReservationRon[] Returns an array of ReservationRon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationRon
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
