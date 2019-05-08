<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about-us", name="about_us")
     */
    public function index()
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    /**
     * @Route("/contact", name="contact_us")
     */
    public function contact()
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
    /**
     * @Route("/terms", name="terms_condition")
     */
    public function terms()
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    /**
     * @Route("/how-does-it-works", name="how_does_it_works")
     */
    public function how_works()
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
