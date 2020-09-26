<?php

namespace App\Repository;

use App\Entity\Container;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Container|null find($id, $lockMode = null, $lockVersion = null)
 * @method Container|null findOneBy(array $criteria, array $orderBy = null)
 * @method Container[]    findAll()
 * @method Container[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Container::class);
    }

    public function findForList($filter): array
    {
        $qb = $this->createQueryBuilder('c');

        if (isset($filter['status'])) {
            $statuses = $filter['status'];
        } else {
            $statuses = array_values(Container::STATUSES);
        }
        $qb
            ->andWhere('c.status IN (:statuses)')
            ->setParameter('statuses', $statuses)
        ;

        if (isset($filter['place'])) {
            $qb
                ->andWhere('c.place = :place')
                ->setParameter('place', $filter['place'])
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
