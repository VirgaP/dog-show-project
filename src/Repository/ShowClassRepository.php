<?php

namespace App\Repository;

use App\Entity\ShowClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShowClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShowClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShowClass[]    findAll()
 * @method ShowClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShowClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShowClass::class);
    }

//    /**
//     * @return ShowClass[] Returns an array of ShowClass objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShowClass
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
