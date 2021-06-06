<?php

namespace App\Repository;

use App\Entity\ProductFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductFiles[]    findAll()
 * @method ProductFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductFiles::class);
    }

     /**
      * @return ProductFiles[] Returns an array of ProductFiles objects
      */

    public function findPartnerFilesByProductId($productId)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.reciever = '."'partner'")
            ->andWhere('f.product = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ProductFiles
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
