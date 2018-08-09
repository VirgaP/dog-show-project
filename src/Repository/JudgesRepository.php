<?php

namespace App\Repository;

use App\Entity\Judges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Judges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Judges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Judges[]    findAll()
 * @method Judges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JudgesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Judges::class);
    }

//    /**
//     * @return Judges[] Returns an array of Judges objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Judges
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
