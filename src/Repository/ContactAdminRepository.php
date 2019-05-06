<?php

namespace App\Repository;

use App\Entity\ContactAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactAdmin[]    findAll()
 * @method ContactAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactAdminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactAdmin::class);
    }

    // /**
    //  * @return ContactAdmin[] Returns an array of ContactAdmin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactAdmin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
