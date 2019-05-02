<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\SearchRideType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_page")
     */
    public function index(Request $request)
    {

        $form = $this->createForm(SearchRideType::class, new Ride() );
        $form->handleRequest($request);
        $result_data = [];
        if ($form->isSubmitted() && $form->isValid()) {
            dump(['searching here']); die;

            return $this->redirectToRoute('app_main_page', [
                'result_data' => $result_data,
                'search_query' =>'done',
            ]);
        }
        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'result_data' => $result_data,
            'search_query' =>null,
        ]);
    }


    /**
     * @Route("/search/location/{q}", name="search_location")
     */
    public function search_location( $q = '')
    {
        return $this->json(['controller_name' => $q ]);
    }
}
