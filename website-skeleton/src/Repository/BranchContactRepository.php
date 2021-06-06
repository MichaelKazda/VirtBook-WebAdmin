<?php

namespace App\Repository;

use App\Entity\BranchContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BranchContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method BranchContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method BranchContact[]    findAll()
 * @method BranchContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BranchContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BranchContact::class);
    }

    // /**
    //  * @return BranchContact[] Returns an array of BranchContact objects
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
    public function findOneBySomeField($value): ?BranchContact
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
