<?php

namespace App\Controller;

use App\Entity\Diploma;
use App\Entity\Registration;
use App\Form\DiplomaType;
use App\Repository\DiplomaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/diploma")
 */
class DiplomaController extends Controller
{
    /**
     * @Route("/", name="diploma_index", methods="GET")
     */
    public function index(DiplomaRepository $diplomaRepository): Response
    {
        $diplomas = $diplomaRepository->findAll();

        return $this->render('diploma/index.html.twig', [
            'diplomas' => $diplomas,
        ]);
    }

    /**
     * @Route("/new/{registration}", name="diploma_new", methods="GET|POST")
     */
    public function new(Request $request, Registration $registration): Response
    {
        $diploma = new Diploma();

        $form = $this->createForm(DiplomaType::class, $diploma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $diploma->setRegistration($registration);
            $em->persist($diploma);
            $em->flush();

            return $this->redirectToRoute('diploma_index');
        }

        return $this->render('diploma/new.html.twig', [
            'diploma' => $diploma,
            'registration' => $registration->getId(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="diploma_show", methods="GET")
     */
    public function show(Diploma $diploma): Response
    {
        return $this->render('diploma/show.html.twig', ['diploma' => $diploma]);
    }

    /**
     * @Route("/{id}/edit", name="diploma_edit", methods="GET|POST")
     */
    public function edit(Request $request, Diploma $diploma): Response
    {
        $form = $this->createForm(DiplomaType::class, $diploma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diploma_edit', ['id' => $diploma->getId()]);
        }

        return $this->render('diploma/edit.html.twig', [
            'diploma' => $diploma,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="diploma_delete", methods="DELETE")
     */
    public function delete(Request $request, Diploma $diploma): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diploma->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($diploma);
            $em->flush();
        }

        return $this->redirectToRoute('diploma_index');
    }

    /**
     * @Route("/{id}/pdf", name="diploma_pdf")
     */
    public function pdf(Request $request, Diploma $diploma): Response
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('diploma/diploma_pdf.html.twig', [
            'diploma' => $diploma,
        ]);

        $filename = 'diploma_pdf';



        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
}
