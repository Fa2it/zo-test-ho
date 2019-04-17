<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_page")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/search/ride", name="search_ride")
     */
    public function serch_ride()
    {
        return $this->render('main/search.ride.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
