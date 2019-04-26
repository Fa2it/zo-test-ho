<?php

namespace App\Controller;

use App\Entity\ActCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/doactivate", name="app_activate")
     */
    public function do_activate(): Response
    {
        return $this->render('security/activate.html.twig' );
    }

    /**
     * @Route("/activate/{emailCode}", name="app_activating")
     */
    public function activate(ActCode $actCode): Response
    {
        $user = $actCode->getUser();
        if( $user ){
            $actCode->setEmailCode('XXXXX');
            $user->setIsEmail(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
             return $this->redirectToRoute('app_activate_sucess' );
        }

        return $this->render('security/not.activate.html.twig' );
    }


    /**
     * @Route("/sucess", name="app_activate_sucess")
     */
    public function successful_activate(): Response
    {
        return $this->render('security/sucess.activate.html.twig' );
    }


    /**
     * @Route("/phone/activate", name="app_activate_phone")
     */
    public function activate_phone(): Response
    {
        /*
         *
         */

        return $this->render('security/activate.phone.html.twig' );
    }
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
