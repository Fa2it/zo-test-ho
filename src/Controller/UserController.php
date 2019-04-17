<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MyUserType;
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

    /*****************************************************************************************************/
    /*       Admin Section                                                                               */
    /*****************************************************************************************************/


    /**
     * @Route("admin/user/", name="admin_user_index", methods={"GET"})
     */
    public function admin_index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
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

            return $this->redirectToRoute('user_index');
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
        return $this->render('user/show.html.twig', [
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

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
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

        return $this->redirectToRoute('user_index');
    }


}
