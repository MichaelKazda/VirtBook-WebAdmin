<?php

namespace App\Repository;

use App\Entity\OrderSubProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderSubProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSubProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderSubProduct[]    findAll()
 * @method OrderSubProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSubProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSubProduct::class);
    }

    /**
     * Finds sub products of main order
     * @param $mainOrderId
     * @param $branchId
     * @return OrderSubProduct[] Returns an array of OrderSubProduct objects
     */

    public function findSubProducts($mainOrderId, $branchId)
    {
        return $this->createQueryBuilder('s')
            ->select(array("s", "subOrder", "subProd"))
            ->andWhere('s.mainOrderMeta = :mainOrder')
            ->andWhere('subOrder.branch = :branch')
            ->setParameter('mainOrder', $mainOrderId)
            ->setParameter('branch', $branchId)
            ->join('s.subOrderMeta','subOrder')
            ->join('subOrder.product', 'subProd')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?OrderSubProduct
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
