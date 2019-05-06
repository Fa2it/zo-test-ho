<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Helper\Media\ImageFiles\ImageUpload;
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
            // dump( $form->getErrors() ); die;
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $car->setAddress(  $this->getUser()->getAddress() );
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
        if( $car ){
            $form = $this->createForm(CarType::class, $car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $car->setAddress( $this->getUser()->getAddress());
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('my_car_show', [
                    'id' => $car->getId(),
                ]);
            }

            return $this->render('car/my/edit.html.twig', [
                'car' => $car,
                'form' => $form->createView(),
            ]);
        }
        return $this->render('car/my/edit.html.twig', [
            'car' => null,
            'form' => null,
        ]);

    }

    /**
     * @Route("/my/car/{id}/delete/{_token}", name="my_car_delete", methods={"GET"})
     */
    public function delete(Request $request, CarRepository $carRepository, $id, $_token,ImageUpload $imageUpload ): Response
    {
        $car = $carRepository->findOneBy(['user'=>$this->getUser(),'id'=>$id]);
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $_token) ) {
            $imageUpload->setImageUploadDir('car_images/');
            $imageUpload->removeImage(trim($car->getImage()) );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_car_index');
    }

    /**
     * @Route("/my/car/photo/upload", name="my_car_photo", methods={"POST"})
     */
    public function car_photo(Request $request,ImageUpload $imageUpload ): Response
    {

        $imageUpload->setImageUploadDir('car_images/');
        $imageUpload->setResizeValue(300);
        $up_file_names =  $imageUpload->upload( $request->files->get('carPhoto') );

        return $this->json(['file_name' => $up_file_names ]);
    }

    /**
     * @Route("/my/car/photo/upload/delete", name="my_car_photo_delete", methods={"POST"})
     */
    public function car_photo_delete(Request $request,ImageUpload $imageUpload, CarRepository $carRepository ): Response
    {
        //TODO use Ajax to delete image
        $imageUpload->setImageUploadDir('car_images/');
        $r = $imageUpload->removeImage( $request->request->get('fid') );

        $car = $carRepository->findOneBy(['user'=>$this->getUser()]);
       if( trim( $car->getImage() ) == trim($request->request->get('fid'))){
           $car->setImage('');
           $this->getDoctrine()->getManager()->flush();
       }

        return $this->json(['file_remove' => $r ]);
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
