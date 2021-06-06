<?php

namespace App\Repository;

use App\Entity\OrderMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderMeta[]    findAll()
 * @method OrderMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderMetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderMeta::class);
    }

    /**
     * Get all orders by branch id
     * @param $branchId
     * @return OrderMeta[] Returns an array of OrderMeta objects
     */

    public function findOrdersByBranch($branchId){
        return $this->createQueryBuilder('o')
            ->select(array("o", "bill", "customer", "product", "branch"))
            ->andWhere('o.isMainOrder = 1')
            ->andWhere('o.active = 1')
            ->andWhere('o.done = 0')
            ->andWhere('o.branch = :branch')
            ->setParameter('branch', $branchId)
            ->join('o.branch', 'branch')
            ->join('o.orderBill','bill')
            ->join('bill.customer','customer')
            ->join('o.product','product')
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOrderById($orderId, $branchId){
        return $this->createQueryBuilder('o')
            ->select(array("o", "bill", "customer", "product", "branch"))
            ->andWhere('o.id = :orderId')
            ->andWhere('o.active = 1')
            ->andWhere('o.done = 0')
            ->andWhere('o.branch = :branch')
            ->setParameter('branch', $branchId)
            ->setParameter('orderId', $orderId)
            ->join('o.orderBill','bill')
            ->join('bill.customer','customer')
            ->join('o.product','product')
            ->join('o.branch', 'branch')
            ->getQuery()
            ->getResult();
    }

    public function findOrderByCode($code, $branchId){
        return $this->createQueryBuilder('o')
            ->select(array("o", "bill", "customer", "product", "branch"))
            ->andWhere('o.code = :code')
            ->andWhere('o.active = 1')
            ->andWhere('o.done = 0')
            ->andWhere('o.branch = :branch')
            ->setParameter('code', $code)
            ->setParameter('branch', $branchId)
            ->orderBy('o.isMainOrder','DESC')
            ->join('o.orderBill','bill')
            ->join('bill.customer','customer')
            ->join('o.product','product')
            ->join('o.branch', 'branch')
            ->getQuery()
            ->getResult();
    }

    public function updateOrderById($orderId, $row, $data){
        $this->createQueryBuilder('o')
            ->update()
            ->set('o.'.$row, ':data')
            ->andWhere('o.id = :orderId')
            ->setParameter(':data', $data)
            ->setParameter(':orderId', $orderId)
            ->getQuery()
            ->execute();
    }
}
