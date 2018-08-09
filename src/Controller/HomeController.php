<?php

namespace App\Controller;

use App\Entity\Home;
use App\Entity\Registration;
use App\Form\HomeType;
use App\Repository\HomeRepository;
use App\Repository\PostRepository;
use App\Repository\RegistrationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(HomeRepository $homeRepository, PostRepository $postRepository, RegistrationRepository $registrationRepository)
    {
//        $registrations = $registrationRepository->countAllPendingRegistrations();
        return $this->render('home/index.html.twig', array(
            'home' => $homeRepository->findAll(),
            'posts'=>$postRepository->findALLPublished(),
            'pending_registrations'=>$registrationRepository->findAllWhereNotConfirmed(),
//            'pending_registrations'=>$registrationRepository->countAllPendingRegistrations(),

        ));
        dump($registrations);
    }

    /**
     * @Route("/admin/home/new", name="home_new")
     */
    public function newHome(Request $request)
    {
        $home = new Home();
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($home);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/new.html.twig', [
            'home' => $home,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/home/edit/{id}", name="home_edit")
     */
    public function editHome(Request $request, Home $home)
    {
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Page is edited successfully");
            return $this->redirectToRoute('home_edit', ['id' => $home->getId()]);
        }
        return $this->render('admin/home_edit.html.twig', [
            'home' => $home,
            'form' => $form->createView(),
        ]);
    }

}
