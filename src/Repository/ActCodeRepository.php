<?php

namespace App\Repository;

use App\Entity\ActCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActCode[]    findAll()
 * @method ActCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActCode::class);
    }

    // /**
    //  * @return ActCode[] Returns an array of ActCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActCode
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
