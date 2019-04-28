<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/my/car/", name="my_car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('car/my/index.html.twig', [
            'cars' => $carRepository->findBy(['user'=>$this->getUser()])
        ]);
    }

    /**
     * @Route("/my/car/new", name="my_car_new", methods={"GET","POST"})
     */
    public function new(Request $request, CarRepository $carRepository): Response
    {
        // user allowed to create max 3 cars
        $cars = $carRepository->findBy(['user'=>$this->getUser()]);

        if( count( $cars ) < 3 ){
            $car = new Car();
            $car->setUser( $this->getUser() );
            $form = $this->createForm(CarType::class, $car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($car);
                $entityManager->flush();
                return $this->redirectToRoute('my_car_index');
            }

            return $this->render('car/my/new.html.twig', [
                'car' => $car,
                'form' => $form->createView(),
            ]);
        }
        return $this->render('car/my/new.html.twig', [
            'car' => null,
            'form' => null,
        ]);
    }

    /**
     * @Route("/my/car/{id}", name="my_car_show", methods={"GET"})
     */
    public function show(CarRepository $carRepository, $id ): Response
    {
        return $this->render('car/my/show.html.twig', [
            'car' => $carRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]),
        ]);
    }

    /**
     * @Route("/my/car/{id}/edit", name="my_car_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarRepository $carRepository, $id): Response
    {
        $car = $carRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('my_car_index', [
                'id' => $car->getId(),
            ]);
        }

        return $this->render('car/my/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/my/car/{id}/delete/{_token}", name="my_car_delete", methods={"GET"})
     */
    public function delete(Request $request, CarRepository $carRepository, $id, $_token ): Response
    {
        $car = $carRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]);
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $_token) ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_car_index');
    }



    /*********************************************************************************/
    /*
     * Admin Section
     */

    /**
     * @Route("/admin/car/", name="car_index", methods={"GET"})
     */
    public function admin_index(CarRepository $carRepository): Response
    {
        return $this->render('car/admin/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/car/new", name="car_new", methods={"GET","POST"})
     */
    public function admin_new(Request $request): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/admin/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/car/{id}", name="car_show", methods={"GET"})
     */
    public function admin_show(Car $car): Response
    {
        return $this->render('car/admin/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/admin/car/{id}/edit", name="car_edit", methods={"GET","POST"})
     */
    public function admin_edit(Request $request, Car $car): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_index', [
                'id' => $car->getId(),
            ]);
        }

        return $this->render('car/admin/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/car/{id}", name="car_delete", methods={"DELETE"})
     */
    public function admin_delete(Request $request, Car $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_index');
    }


}
