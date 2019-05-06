<?php

namespace App\Controller;

use App\Entity\ContactAdmin;
use App\Entity\User;
use App\Form\UserContactAdminType;
use App\Repository\ContactAdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContactAdminController extends AbstractController
{

    /**
     * @Route("my/contact/administrator", name="my_contact_admin", methods={"GET","POST"})
     */
    public function contact_admin(Request $request): Response
    {
        $contactAdmin = new ContactAdmin();
        $contactAdmin->setEmail($this->getUser()->getEmail());
        $is_posted = false;
        $form = $this->createForm(UserContactAdminType::class, $contactAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactAdmin);
            $entityManager->flush();
            $is_posted = true;
        }

        return $this->render('contact_admin/new.html.twig', [
            'contact_admin' => $contactAdmin,
            'is_posted'=>$is_posted,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="contact_admin_show", methods={"GET"})
     *
    public function show(ContactAdmin $contactAdmin): Response
    {
        return $this->render('contact_admin/show.html.twig', [
            'contact_admin' => $contactAdmin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_admin_edit", methods={"GET","POST"})
     *
    public function edit(Request $request, ContactAdmin $contactAdmin): Response
    {
        $form = $this->createForm(ContactAdminType::class, $contactAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_admin_index', [
                'id' => $contactAdmin->getId(),
            ]);
        }

        return $this->render('contact_admin/edit.html.twig', [
            'contact_admin' => $contactAdmin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_admin_delete", methods={"DELETE"})
     *
    public function delete(Request $request, ContactAdmin $contactAdmin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactAdmin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contactAdmin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_admin_index');
    }
    */
}
