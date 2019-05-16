<?php

namespace App\Controller;

use App\Entity\ActCode;
use App\Entity\PwdCode;
use App\Entity\User;
use App\Form\MyUserPwdType;
use App\Helper\CodeGenerator\CodeGenerator;
use App\Message\EmailRegistration;
use App\Repository\PwdCodeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
            $this->getDoctrine()->getManager()->flush();
             return $this->redirectToRoute('app_activate_sucess' );
        }

        return $this->render('security/not.activate.html.twig' );
    }

    /**
     * @Route("/pwd/new", name="app_pwd_new",  methods={"GET","POST"})
     */
    public function pwd(Request $request, UserRepository $userRepository, EmailRegistration $eR, CodeGenerator $cd, UserPasswordEncoderInterface $passwordEncoder ): Response
    {
        $result = '';

        if ($this->isCsrfTokenValid('password', $request->request->get('_token'))) {
            $user = $userRepository->findOneBy(['email'=>$request->request->get('email')]);
            if( $user ){
                $pwdCode = new PwdCode();

                $pwdCode_in = $cd->random_string( str_shuffle('abcd890efghi123jklm45nopqrst67uvwxyz'),60 );
                $pwdCode->setEmail( $user->getEmail());
                $pwdCode->setCode( $pwdCode_in );
                $pwd = $cd->random_string('', random_int(5,8) );
                $eR->sendPassword($user, $pwd , $pwdCode_in );
                $user->setPassword( $passwordEncoder->encodePassword($user,  $pwd  ) );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pwdCode);
                $entityManager->flush();
                $result = 'done';
            } else {
                $result = 'email not found';
            }

        }

        return $this->render('security/pwd.new.html.twig',[
            'result'=> $result,
        ]);
    }

    /**
     * @Route("/reset/password/{code}", name="app_pwd_reset",  methods={"GET","POST"})
     */
    public function pwd_reset(PwdCode $pwdCode, Request $request, EmailRegistration $eR,  UserPasswordEncoderInterface $passwordEncoder, UserRepository $uR, PwdCodeRepository $pcR ): Response
    {

        $user = $uR->findOneBy( ['email'=> $pwdCode->getEmail() ] );
        $pwd_success = false;
        $form = $this->createForm(MyUserPwdType::class, $user );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pwdCodes = $pcR->findBy(['email'=> $form->getData()->getEmail() ] );
            $user->setPassword( $passwordEncoder->encodePassword($user,  $form->getData()->getPassword() ) );
            $entityManager = $this->getDoctrine()->getManager();
            foreach ( $pwdCodes as $user_service) {
                $entityManager->remove($user_service);
            }
            $entityManager->flush();
            $pwd_success = true;
        }

        return $this->render('security/pwd.reset.html.twig',[
            'form'=> $form->createView(),
            'pwd_sucess'=>  $pwd_success
        ]);

    }

    /**
     * @Route("/reset/password/success", name="app_pwd_reset_success",  methods={"GET"})
     */
    public function pwd_reset_success(Request $request ): Response
    {

        return $this->render('security/sucess.password.html.twig' );

    }

    /**
     * @Route("/success", name="app_activate_sucess")
     */
    public function successful_password(): Response
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
