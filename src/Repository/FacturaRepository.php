<?php

namespace App\Repository;

use App\Entity\Factura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factura>
 */
class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }

    public function findFacturasWithClient(): array
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.client', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    }

    public function findFacturasWithObras(): array
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.obra', 'o')
            ->addSelect('o')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Factura[] Returns an array of Factura objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Factura
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ;
    }

    public function findByTextQuery(string $value): Query
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.num_factura LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ;
    }
}
