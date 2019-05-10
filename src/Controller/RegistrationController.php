<?php

namespace App\Controller;

use App\Entity\ActCode;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Helper\CodeGenerator\CodeGenerator;
use App\Message\EmailRegistration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailRegistration $eR ): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $act_code = new ActCode();
            $str ="12345fghijklmnopqrstuvwxyzABCDEFGH67890abcdeIJKLMNOPQRSTUVWXYZ";
            $act_code->setEmailCode( ( new CodeGenerator() )->random_string($str, 40 ) );
            $act_code->setPhoneCode( 'XXXXX' );
            $user->setActCode($act_code);
            $user->setIpAddress($request->getClientIp() );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $eR->send($user);
            return $this->redirectToRoute('app_activate', ['user'=>$user]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /*
     * @Route("/register/successful", name="app_register_success")
     */

    public function register_success(){

    }
}
