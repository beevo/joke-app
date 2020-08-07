<?php

namespace App\Repository;

use App\Entity\Joke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Joke|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joke|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joke[]    findAll()
 * @method Joke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JokeRepository extends ServiceEntityRepository
{
    public static $minPerPage = 1;
    public static $maxPerPage = 100;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joke::class);
    }
    
    // /**
    //  * @return int Returns the max amount of jokes per page
    //  */
    public function getMaxPerPage()
    {
        return self::$maxPerPage;
    }

    // /**
    //  * @return int Returns the min amount of jokes per page
    //  */
    public function getMinPerPage()
    {
        return self::$minPerPage;
    }
        
    // /**
    //  * @return Joke[] Returns an array of Joke objects based on pagination paramters
    //  */
    public function findByPage($page, $perPage)
    {
        $firstResults = ($page - 1)*$perPage;
        return $this->createQueryBuilder('j')
            ->setFirstResult($firstResults)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return int Returns the total count of all jokes in repo
    //  */
    public function getTotal()
    {
        return intval($this->createQueryBuilder('j')
            ->select('count(j.id)')
            ->getQuery()
            ->getSingleScalarResult())
        ;
    }
    

    // /**
    //  * @return Joke[] Returns an array of Joke objects
    //  */
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
    public function findOneBySomeField($value): ?Joke
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
