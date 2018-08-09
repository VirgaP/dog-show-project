<?php

namespace App\Repository;

use App\Entity\Dog;
use App\Entity\Registration;
use App\Entity\Show;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Show|null find($id, $lockMode = null, $lockVersion = null)
 * @method Show|null findOneBy(array $criteria, array $orderBy = null)
 * @method Show[]    findAll()
 * @method Show[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Show::class);
    }

    public function createDateQueryBuilder()
    {
        return $this->createQueryBuilder('show')
            ->select('dateShow')
            ->where('show.dateShow > :date')
            ->setParameter('date', 'now()')
            ->orderBy('ASC');
    }

    public function findShowsByDog(Dog $dog)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(Registration::class,'r', 'with', 's = r.show')
            ->innerJoin(Dog::class, 'd','with', 'r.dog = d' )
            ->where('d.id =:id')
            ->setParameter('id', $dog->getId())
            ->getQuery()
            ->getResult();

    }

    public function findShowRegistrations($showId)
    {
        $qb = $this->createQueryBuilder('s')
            ->innerJoin('s.registrations', 'r')
            ->addSelect('r')
            ->where('r.inCatalogue=1')
            ->andWhere('s.id = :id')
            ->setParameter('id', $showId);
        return $qb->getQuery()->getResult();

    }


//    public function findMaleDogsByClass($showClassId, $dogId)
//    {
//             $query=$this->createQueryBuilder('s')
//                 ->leftJoin('s.registrations', 'r')
//                 ->leftjoin('r.class', 'sc')
//                 ->andWhere('sc.id =:class')
//                 ->setParameter('class',$showClassId)
//                 ->leftjoin('r.dog', 'd')
//                 ->andWhere('r.dog = :dog')
//                 ->setParameter('dog', $dogId)
//                 ->andWhere('d.sex =:male')
//                 ->setParameter('male', 'male');
//
//        return $query->getQuery()->getResult();
//
//    }


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
    public function findOneBySomeField($value): ?Show
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
