<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\SearchRideType;
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
        $q = $request->query->get('search_ride');
        if ($this->isCsrfTokenValid('search_ride', $q['_token']) ) {
            // dump( $q ); die;
            $rides = $rideR->findBySearch( $q );
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'rides' => $rides,
            'search_query' =>null,
        ]);
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
