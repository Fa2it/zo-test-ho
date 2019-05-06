<?php

namespace App\Repository;

use App\Entity\PwdCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PwdCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PwdCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PwdCode[]    findAll()
 * @method PwdCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PwdCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PwdCode::class);
    }

    // /**
    //  * @return PwdCode[] Returns an array of PwdCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PwdCode
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
