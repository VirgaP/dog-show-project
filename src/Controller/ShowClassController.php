<?php

namespace App\Controller;

use App\Entity\ShowClass;
use App\Form\ShowClassType;
use App\Repository\ShowClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/show/class")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class ShowClassController extends Controller
{
    /**
     * @Route("/", name="show_class_index", methods="GET")
     */
    public function index(ShowClassRepository $showClassRepository): Response
    {
        return $this->render('show_class/index.html.twig', ['show_classes' => $showClassRepository->findAll()]);
    }

    /**
     * @Route("/new", name="show_class_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $showClass = new ShowClass();
        $form = $this->createForm(ShowClassType::class, $showClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($showClass);
            $em->flush();

            return $this->redirectToRoute('show_class_index');
        }

        return $this->render('show_class/new.html.twig', [
            'show_class' => $showClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_class_show", methods="GET")
     */
    public function show(ShowClass $showClass): Response
    {
        return $this->render('show_class/show.html.twig', ['show_class' => $showClass]);
    }

    /**
     * @Route("/{id}/edit", name="show_class_edit", methods="GET|POST")
     */
    public function edit(Request $request, ShowClass $showClass): Response
    {
        $form = $this->createForm(ShowClassType::class, $showClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_class_edit', ['id' => $showClass->getId()]);
        }

        return $this->render('show_class/edit.html.twig', [
            'show_class' => $showClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_class_delete", methods="DELETE")
     */
    public function delete(Request $request, ShowClass $showClass): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showClass->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($showClass);
            $em->flush();
        }

        return $this->redirectToRoute('show_class_index');
    }
}
