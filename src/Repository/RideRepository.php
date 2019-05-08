<?php

namespace App\Repository;

use App\Entity\Ride;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ride|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ride|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ride[]    findAll()
 * @method Ride[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ride::class);
    }

    /**
     * @return Ride[] Returns an array of Ride objects
    */

    public function findBySearch( array $value)
    {
        // dump( $time_now->format('H:i:s') ); die;
        return $this->searchQB($value)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Ride[] Returns an array of Ride objects
     */

    public function findBySearchCount( array $value)
    {
        // dump( $time_now->format('H:i:s') ); die;
        return $this->searchQB($value)
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findOneByScroll(array $value)
    {
        $oset = 10 + intval( $value['next'] );
        return $this->searchQB($value)
            ->setMaxResults(1)
            ->setFirstResult( $oset )
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    private function searchQB( array $value){
        return $this->createQueryBuilder('r')
            ->andWhere('r.pickUp = :pickUp')
            ->setParameter('pickUp', $value['pickUp'])
            ->andWhere('r.dropOff = :dropOff')
            ->setParameter('dropOff', $value['dropOff'])
            ->andWhere('r.pickUpDate = :pickUpDate')
            ->setParameter('pickUpDate', $this->germanTimeToDate( $value['pickUpDate'] ) )
            ->orderBy('r.pickUpTime', 'ASC');
    }

    private function germanTimeToDate( string $gdate ){
        // 03.05.2019
        $r = explode(".", $gdate );
        if( count($r) == 3 ){
            return new \DateTime($r[2].'/'.$r[1].'/'.$r[0]);
        }
        return null;
    }



    // /**
    //  * @return Ride[] Returns an array of Ride objects
    //  */
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
    public function findOneBySomeField($value): ?Ride
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
