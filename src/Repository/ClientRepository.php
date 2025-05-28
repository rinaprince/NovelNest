<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'PARTIAL f.{id, num_factura}', 'PARTIAL o.{id, nom}')
            ->leftJoin('c.factures', 'f')
            ->leftJoin('c.obres', 'o')
            ->orderBy('c.id', 'ASC')
            ->getQuery();
    }

    public function findByTextQuery(string $value): Query
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'PARTIAL f.{id, num_factura}', 'PARTIAL o.{id, nom}')
            ->leftJoin('c.factures', 'f')
            ->leftJoin('c.obres', 'o')
            ->where('c.cognom LIKE :val OR c.nom LIKE :val OR c.pseudonim LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('c.id', 'ASC')
            ->getQuery();
    }
}