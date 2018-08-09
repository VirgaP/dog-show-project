<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Form\CatalogueType;
use App\Repository\CatalogueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalogue")
 */
class CatalogueController extends Controller
{
    /**
     * @Route("/", name="catalogue_index", methods="GET")
     */
    public function index(CatalogueRepository $catalogueRepository): Response
    {
        return $this->render('catalogue/index.html.twig', ['catalogues' => $catalogueRepository->findAll()]);
    }

    /**
     * @Route("/new", name="catalogue_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $catalogue = new Catalogue();
        $form = $this->createForm(CatalogueType::class, $catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($catalogue);
            $em->flush();

            return $this->redirectToRoute('catalogue_index');
        }

        return $this->render('catalogue/new.html.twig', [
            'catalogue' => $catalogue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="catalogue_show", methods="GET")
     */
    public function show(Catalogue $catalogue): Response
    {
        return $this->render('catalogue/show.html.twig', ['catalogue' => $catalogue]);
    }

    /**
     * @Route("/{id}/edit", name="catalogue_edit", methods="GET|POST")
     */
    public function edit(Request $request, Catalogue $catalogue): Response
    {
        $form = $this->createForm(CatalogueType::class, $catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('catalogue_edit', ['id' => $catalogue->getId()]);
        }

        return $this->render('catalogue/edit.html.twig', [
            'catalogue' => $catalogue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="catalogue_delete", methods="DELETE")
     */
    public function delete(Request $request, Catalogue $catalogue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catalogue->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($catalogue);
            $em->flush();
        }

        return $this->redirectToRoute('catalogue_index');
    }
}
