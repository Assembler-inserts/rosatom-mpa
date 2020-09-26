<?php

namespace App\Repository;

use App\Entity\Tower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tower[]    findAll()
 * @method Tower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tower::class);
    }

    // /**
    //  * @return Tower[] Returns an array of Tower objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tower
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
