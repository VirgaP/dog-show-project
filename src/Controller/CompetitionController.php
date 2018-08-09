<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/competition")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class CompetitionController extends Controller
{
    /**
     * @Route("/", name="competition_index", methods="GET")
     */
    public function index(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/index.html.twig', ['competitions' => $competitionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="competition_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($competition);
            $em->flush();

            return $this->redirectToRoute('competition_index');
        }

        return $this->render('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competition_show", methods="GET")
     */
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', ['competition' => $competition]);
    }

    /**
     * @Route("/{id}/edit", name="competition_edit", methods="GET|POST")
     */
    public function edit(Request $request, Competition $competition): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('competition_edit', ['id' => $competition->getId()]);
        }

        return $this->render('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competition_delete", methods="DELETE")
     */
    public function delete(Request $request, Competition $competition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($competition);
            $em->flush();
        }

        return $this->redirectToRoute('competition_index');
    }
}
