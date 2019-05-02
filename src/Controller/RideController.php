<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Ride;
use App\Form\RideType;
use App\Repository\CarRepository;
use App\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RideController extends AbstractController
{
    /**
     * @Route("/my/ride/", name="my_ride_index", methods={"GET"})
     */
    public function index(RideRepository $rideRepository): Response
    {
        return $this->render('ride/my/index.html.twig', [
            'rides' => $rideRepository->findBy(['user'=>$this->getUser()]),
        ]);
    }

    /**
     * @Route("/my/ride/new", name="my_ride_new", methods={"GET","POST"})
     */
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $ride = new Ride();
        $user = $this->getUser();
        $ride->setUser( $user );
        $car_data = ['car_data'=>$carRepository->findBy( ['user'=>$user] ) ];
        $form = $this->createForm(RideType::class, $ride, $car_data );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ride);
            $entityManager->flush();

            return $this->redirectToRoute('my_ride_index');
        }


        return $this->render('ride/my/new.html.twig', [
            'car_data'=> $car_data['car_data'],
            'ride' => $ride,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/my/ride/{id}", name="my_ride_show", methods={"GET"})
     */
    public function show(Ride $ride): Response
    {
        return $this->render('ride/my/show.html.twig', [
            'ride' => $ride,
        ]);
    }

    /**
     * @Route("/my/ride/{id}/edit", name="my_ride_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RideRepository $rideRepository, $id, CarRepository $carRepository): Response
    {
        $ride = $rideRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]);
        $car_data = [];
        if( $ride ){
            $car_data = ['car_data'=>$carRepository->findBy( ['user'=>$this->getUser()] ) ];
            $form = $this->createForm(RideType::class, $ride, $car_data );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('my_ride_index', [
                    'id' => $ride->getId(),
                ]);
            }

            return $this->render('ride/my/edit.html.twig', [
                'ride' => $ride,
                'form' => $form->createView(),
                'car_data'=>$car_data,
            ]);
        }
        return $this->render('ride/my/edit.html.twig', [
            'ride' => null,
            'form' => null,
            'car_data'=>$car_data,
        ]);
    }

    /**
     * @Route("/my/ride/{id}/delete/{_token}", name="my_ride_delete", methods={"GET"})
     */
    public function delete(Request $request, RideRepository $rideRepository, $id, $_token): Response
    {
        $ride = $rideRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]);
        if ($this->isCsrfTokenValid('delete'.$ride->getId(), $_token) ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ride);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_ride_index');
    }


    /*
     * Admin Area
     */
    /**
     * @Route("/", name="ride_index", methods={"GET"})
     */
    public function admi_index(RideRepository $rideRepository): Response
    {
        return $this->render('ride/index.html.twig', [
            'rides' => $rideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ride_new", methods={"GET","POST"})
     *
    public function admin_new(Request $request): Response
    {
        $ride = new Ride();
        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ride);
            $entityManager->flush();

            return $this->redirectToRoute('ride_index');
        }

        return $this->render('ride/new.html.twig', [
            'ride' => $ride,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ride_show", methods={"GET"})
     *
    public function admin_show(Ride $ride): Response
    {
        return $this->render('ride/show.html.twig', [
            'ride' => $ride,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ride_edit", methods={"GET","POST"})
     *
    public function admin_edit(Request $request, Ride $ride): Response
    {
        $form = $this->createForm(RideType::class, $ride);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ride_index', [
                'id' => $ride->getId(),
            ]);
        }

        return $this->render('ride/edit.html.twig', [
            'ride' => $ride,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ride_delete", methods={"DELETE"})
     *
    public function admin_delete(Request $request, Ride $ride): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ride->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ride);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ride_index');
    }


     */
}
