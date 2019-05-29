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


        $today =  new \DateTime( date('Y/m/d') );
        $ride_time = '00:00:00';
        $pick_up_date = $this->germanTimeToDate( $value['pickUpDate'] );
        if( $today ==  $pick_up_date ){
            $ride_time = ( new \DateTime( date('H.i') ) )->format('H:i:s');
        }

        return $this->createQueryBuilder('r')
            ->andWhere('r.pickUp = :pickUp')
            ->setParameter('pickUp', $value['pickUp'])
            ->andWhere('r.dropOff = :dropOff')
            ->setParameter('dropOff', $value['dropOff'])
            ->andWhere('r.pickUpDate = :pickUpDate')
            ->setParameter('pickUpDate', $pick_up_date )
            ->andWhere('r.pickUpTime BETWEEN :from AND :to' )
            ->setParameter('from',$ride_time )
            ->setParameter('to', '23:59:00')
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

    /**
     * @return Ride[] Returns an array of Ride objects
     */

     public function findByQuickSearch($p, $d){

            return $this->searchQQB( $p, $d )
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;


     }

     public function findByQuickSearchCount($p, $d){
         return $this->searchQQB( $p, $d )
             ->select('count(r.id)')
             ->getQuery()
             ->getSingleScalarResult()
             ;
     }


    private function searchQQB( $p, $d ){

        $ride_date = new \DateTime( date('Y-m-d'));
        $ride_time = ( new \DateTime( date('H.i')) )->format('H:i:s');

        return $this->createQueryBuilder('r')
            ->andWhere('r.pickUp = :pickUp')
            ->setParameter('pickUp', $p )
            ->andWhere('r.dropOff = :dropOff')
            ->setParameter('dropOff', $d )
            ->andWhere('r.pickUpDate = :pickUpDate')
            ->setParameter('pickUpDate', $ride_date )
            ->andWhere('r.pickUpTime BETWEEN :from AND :to' )
            ->setParameter('from',$ride_time )
            ->setParameter('to', '23:59:00')
            ->orderBy('r.pickUpTime', 'ASC')
             ;
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
