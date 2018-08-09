<?php

namespace App\Repository;

use App\Entity\Dog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @method Dog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dog[]    findAll()
 * @method Dog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogRepository extends ServiceEntityRepository
{

    const POSTS_PER_PAGE = 10;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dog::class);
    }

    public function getAllDogs($currentPage = 1)
    {
        $query = $this->createQueryBuilder('d')
            ->orderBy('d.created_at', 'ASC')
            ->getQuery();


        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    /**
     * @param $dql
     * @param int $page
     * @return Paginator
     */
    public function paginate($dql, $page = 1)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult(self::POSTS_PER_PAGE * ($page - 1))
            ->setMaxResults(self::POSTS_PER_PAGE);
        return $paginator;
    }


    public function getdDogsByOwnerQuery($owner)
    {
        return $this->createQueryBuilder('d')
            ->where('d.owner = :owner')
            ->setParameter('owner', $owner);
//            ->getQuery();
//            ->getResult();
    }

    public function findMaleDogsByClass($showId)
    {
        $query=$this->createQueryBuilder('d')
            ->leftJoin('d.registrations', 'r')
            ->leftJoin('r.show', 's')
            ->andWhere('d.sex =:male')
            ->setParameter('male', 'male')
            ->andWhere('s.id = :id')
            ->setParameter('id', $showId);
//        dump($query->getDQL());
        return $query->getQuery()->getResult();

    }


//    /**
//     * @return Dog[] Returns an array of Dog objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dog
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
