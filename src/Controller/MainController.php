<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\SearchRideType;
use App\Helper\search\RideView;
use App\Repository\GermanyRepository;
use App\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_page" , methods={"GET"})
     */
    public function index(Request $request, RideRepository $rideR )
    {

        $form = $this->createForm(SearchRideType::class, new Ride() );
        $rides = [];
        $submitted = false;
        $ridesCount = 0;
        $q = $request->query->get('search_ride');
        if ($this->isCsrfTokenValid('search_ride', $q['_token']) ) {
            $submitted = true;
            $rides = $rideR->findBySearch( $q );
            $ridesCount = $rideR->findBySearchCount($q);
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'rides' => $rides,
            'ridesCount'=>$ridesCount,
            'is_submitted' =>$submitted,
        ]);
    }
    /**
     * @Route("/search/ride/scroll", name="ride_search_scroll" , methods={"POST"})
     */
    public function search_scroll(Request $request, RideRepository $rR, RideView $rV )
    {

        $r = $request->request->get('_scroll_search');
        $d = ['pickUp'=>$r['_pick_up'],'dropOff'=>$r['_drop_off'],'pickUpDate'=>$r['_pick_up_date'],'next'=>$r['_next'] ];
        $ride = $rR->findOneByScroll( $d );
        if($ride){
            return $this->json( ['ride' => $rV->renderAnchor( $ride) ]);
        } else{
            return $this->json( ['ride' => null ]);
        }

    }

    /**
     * @Route("/search/ride/scroll/test", name="ride_search_scroll_TEST" , methods={"GET","POST"})
     */
    public function search_scroll_test(Request $request, RideRepository $rR,  RideView $rV )
    {

        $r = null;
        $r = $request->request->get('test_form');
        if( $r ){
            $d = ['pickUp'=>$r['_pick_up'],'dropOff'=>$r['_drop_off'],'pickUpDate'=>$r['_pick_up_date'],'next'=>$r['_next'] ];
            $ride = $rR->findOneByScroll( $d );
            $a = $rV->renderAnchor($ride);
            dump($a ); die;
        }
        return $this->render('main/search.test.html.twig');

    }
    /**
     * @Route("my/search/{id}/details", name="ride_search_details" , methods={"GET"})
     */
    public function search_details( Ride $rideR )
    {

        return $this->render('main/ride.html.twig', [
            'ride' => $rideR,
        ]);
    }

    /**
     * @Route("contact/administrator", name="contact_admin" , methods={"GET"})
     */
    public function pub_contact_admin( RideRepository $rideR )
    {

        return $this->render('main/contact.admin.html.twig' );
    }
    /**
     * @Route("/search/location/{q}", name="search_location")
     */
    public function search_location( $q = '', GermanyRepository $g )
    {
        return $this->json( $g->findOrtLike( $q ) );
    }
}
