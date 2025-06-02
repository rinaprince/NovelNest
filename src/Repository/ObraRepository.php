<?php

namespace App\Repository;

use App\Entity\Obra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Obra>
 */
class ObraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Obra::class);
    }

    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->getQuery();
    }

    public function findByTextQuery(string $value): Query
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.nom LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('o.id', 'ASC')
            ->getQuery();
    }

    public function save(Obra $obra, bool $flush = false): void
    {
        $this->getEntityManager()->persist($obra);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}