<?php

namespace App\Repository;

use App\Entity\BranchMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BranchMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method BranchMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method BranchMedia[]    findAll()
 * @method BranchMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BranchMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BranchMedia::class);
    }

    // /**
    //  * @return BranchMedia[] Returns an array of BranchMedia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BranchMedia
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
