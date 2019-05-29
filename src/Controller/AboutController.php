<?php

namespace App\Controller;

use App\Entity\ContactAdmin;
use App\Form\ContactAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about-us", name="about_us")
     */
    public function index()
    {
        return $this->render('about/about.us.html.twig');
    }

    /**
     * @Route("/contact", name="about_contact_us")
     */
    public function contact(Request $request)
    {

        $contactAdmin = new ContactAdmin();
        $is_posted = false;
        $form = $this->createForm(ContactAdminType::class, $contactAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactAdmin);
            $entityManager->flush();
            $is_posted = true;
        }
        return $this->render('about/contact.us.html.twig', [
            'contact_admin' => $contactAdmin,
            'is_posted'=>$is_posted,
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/terms", name="about_terms_condition")
     */
    public function terms()
    {
        return $this->render('about/terms.html.twig');
    }

    /**
     * @Route("/how-it-works", name="about_how_it_works")
     */
    public function how_it_works()
    {
        return $this->render('about/how.it.works.html.twig');
    }
}
