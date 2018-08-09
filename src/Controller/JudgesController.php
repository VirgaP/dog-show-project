<?php

namespace App\Controller;

use App\Entity\Judges;
use App\Form\JudgesType;
use App\Repository\JudgesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/judges")
 */
class JudgesController extends Controller
{
    /**
     * @Route("/", name="judges_index", methods="GET")
     */
    public function index(JudgesRepository $judgesRepository): Response
    {
        return $this->render('judges/index.html.twig', ['judges' => $judgesRepository->findAll()]);
    }

    /**
     * @Route("/new", name="judges_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $judge = new Judges();
        $form = $this->createForm(JudgesType::class, $judge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($judge);
            $em->flush();

            return $this->redirectToRoute('judges_index');
        }

        return $this->render('judges/new.html.twig', [
            'judge' => $judge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="judges_show", methods="GET")
     */
    public function show(Judges $judge): Response
    {
        return $this->render('judges/show.html.twig', ['judge' => $judge]);
    }

    /**
     * @Route("/{id}/edit", name="judges_edit", methods="GET|POST")
     */
    public function edit(Request $request, Judges $judge): Response
    {
        $form = $this->createForm(JudgesType::class, $judge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('judges_index');
        }

        return $this->render('judges/edit.html.twig', [
            'judge' => $judge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="judges_delete", methods="DELETE")
     */
    public function delete(Request $request, Judges $judge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$judge->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($judge);
            $em->flush();
        }

        return $this->redirectToRoute('judges_index');
    }
}
