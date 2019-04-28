<?php

namespace App\Controller;

use App\Entity\ActCode;
use App\Helper\CodeGenerator\CodeGenerator;
use App\Entity\User;
use App\Form\MyUserEmailType;
use App\Form\MyUserPhoneType;
use App\Form\MyUserType;
use App\Form\UserType;
use App\Helper\Media\ImageFiles\ImageUpload;
use App\Message\EmailRegistration;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    /**
     * @Route("my/profile", name="my_user_index", methods={"GET"})
     */
    public function index(): Response
    {

        return $this->render('user/my/show.html.twig', [
            'user' => $this->security->getUser(),
        ]);
    }

    /**
     * @Route("my/profile/show", name="my_user_profile_show", methods={"GET","POST"})
     */
    public function profile_show(Request $request): Response
    {

        $user = $this->security->getUser();
        $form = $this->createForm(MyUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('my_user_index' );
        }

        return $this->render('user/my/edit.profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("my/profile/edit", name="my_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(MyUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('my_user_index' );
        }

        return $this->render('user/my/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("my/profile/email/verify", name="my_user_verify", methods={"GET","POST"})
     */
    public function verify( Request $request, EmailRegistration $eR ): Response
    {
        /* @var User $user */
        $user = $this->security->getUser();
        $emailForm = $this->createForm(MyUserEmailType::class, $user);
        $phoneForm = $this->createForm(MyUserPhoneType::class, $user);
        $emailForm->handleRequest($request);
        $phoneForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $user->setIsEmail( 0 );
            $act_code = $user->getActCode();
            $act_code->setEmailCode( ( new CodeGenerator() )->random_string('', 13 ) );
            // $act_code->setPhoneCode( 'XXXXX' );
            $user->setActCode($act_code);

            $this->getDoctrine()->getManager()->flush();

            $eR->send($user);
            /* log user out */
            $this->get('session')->invalidate();
            $this->get('security.token_storage')->setToken(null);

            /* delete remeber me cookie */
            $response = new Response();
            $response->headers->clearCookie('REMEMBERME');
            $response->send();

            return $this->redirectToRoute('app_activate', ['user'=>$user]);
        }


        if ($phoneForm->isSubmitted() && $phoneForm->isValid()) {
            $user->setIsPhone(0);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('my_user_verify' );
        }

        return $this->render('user/my/verify.html.twig',[
            'emailForm' => $emailForm->createView(),
            'phoneForm' => $phoneForm->createView()
            ]
            );
    }


    /**
     * @Route("my/profile/delete", name="my_user_delete", methods={"GET","DELETE"})
     */
    public function delete(Request $request ): Response
    {
        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove( $this->security->getUser() );
            $entityManager->flush();
            $this->get('security.token_storage')->setToken(null);
            $this->get('session')->invalidate();
            return $this->redirectToRoute('app_main_page');
        }

        return $this->render('user/my/delete.html.twig' );

    }
    /**
     * @Route("my/profile/photo", name="my_user_photo", methods={"GET","POST"})
     */
    public function photo(Request $request,ImageUpload $imageUpload ): Response
    {

        if ($this->isCsrfTokenValid('_photo', $request->request->get('_token'))) {
            $user = $this->security->getUser();
            $imageUpload->setImageUploadDir('images/');
            $up_file_names =  $imageUpload->upload( $request->files->get('profilePhoto') );

            //dump($up_file_names ); die;
            $imageUpload->setResizeValue(300);
            $imageUpload->setFileName($up_file_names[0]);
            $imageUpload->setImageUploadDir('thumbnail/');
            $r_upfilenames =  $imageUpload->upload( $request->files->get('profilePhoto') );
            $user->setPhoto($r_upfilenames[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('my_user_index');

        }

        return $this->render('user/my/photo.html.twig' );

    }

    /**
     * @Route("my/profile/photo/delete", name="my_user_photo_delete", methods={"POST"})
     */
    public function photoRemove(Request $request,ImageUpload $imageUpload ): Response
    {

        if ($this->isCsrfTokenValid('_dphoto', $request->request->get('_token'))) {
            /* @var User $user    */
            $user = $this->security->getUser();
            $user->setPhoto('' );
            $imageUpload->setImageUploadDir('images/');
            $imageUpload->removeImage( $request->request->get('_dprofilePhoto') );
            $imageUpload->setImageUploadDir('thumbnail/');
            $imageUpload->removeImage( $request->request->get('_dprofilePhoto') );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('my_user_index');

        }

        return $this->render('user/my/photo.html.twig' );

    }
    /*****************************************************************************************************/
    /*       Admin Section                                                                               */
    /*****************************************************************************************************/


    /**
     * @Route("admin/user/", name="admin_user_index", methods={"GET"})
     */
    public function admin_index(UserRepository $userRepository): Response
    {
        return $this->render('user/admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/user/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function admin_new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin_user_show", methods={"GET"})
     */
    public function admin_show(User $user): Response
    {
        return $this->render('user/admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("admin/user/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function admin_edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function admin_delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }


}
