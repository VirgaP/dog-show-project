<?php

namespace App\Repository;

use App\Entity\Registration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @method Registration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Registration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Registration[]    findAll()
 * @method Registration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationRepository extends ServiceEntityRepository
{
    const POSTS_PER_PAGE = 10;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Registration::class);
    }


    public function getAllRegistrations($currentPage = 1)
    {
        $query = $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'DESC')
            ->getQuery();


        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    public function getAllByUser($currentPage = 1, $owner)
    {
        $query = $this->createQueryBuilder('r')
            ->leftJoin(
                'r.dog','d'
            )
            ->where('d.owner =:owner')
            ->setParameter('owner', $owner)
            ->orderBy('r.created_at', 'DESC');

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
//            ->getQuery()
//            ->getResult();
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

    public function findAllWhereNotConfirmed()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isConfirmed = 0')
            ->orderBy('r.created_at', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function setAsIsConfirmed($id)
    {
        return $this->createQueryBuilder('r')
            ->update('App:Registration', 'r')
            ->set('r.isConfirmed', 1)
            ->andWhere('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function getAllInCatalogue()
    {
        return $this->createQueryBuilder('r')
            ->where('r.inCatalogue =1')
            ->orderBy('r.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findRegistrationsbyShow($show)
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.show', 's')
//            ->innerJoin('r.class', 'sc')
            ->where('r.inCatalogue=1')
            ->andWhere('s.id = :id')
            ->setParameter('id', $show);
        return $qb->getQuery()->getResult();

    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllPendingRegistrations()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isConfirmed = 0')
            ->select('COUNT(r) AS registrationCount')
            ->getQuery()
//            ->getOneOrNullResult();
            ->getSingleScalarResult();
    }


    public function findAllConfirmed()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isConfirmed = 1')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function filterByRegistrationDate()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function filterbyShow($show)
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.show', 's')
            ->andWhere('s.id = :id')
            ->setParameter('id', $show);
        return $qb->getQuery()->getResult();

    }

//    /**
//     * @return Registration[] Returns an array of Registration objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Registration
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
