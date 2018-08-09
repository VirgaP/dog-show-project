<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Entity\Show;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/show")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class ShowController extends Controller
{
    /**
     * @Route("/", name="show_index", methods="GET")
     */
    public function index(): Response
    {
        $shows = $this->getDoctrine()
            ->getRepository(Show::class)
            ->findAll();

        return $this->render('show/index.html.twig', ['shows' => $shows]);
    }

    /**
     * @Route("/new", name="show_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($show);
                $em->flush();
//                $em->clear();

                return $this->redirectToRoute('show_index');
            }

            return $this->render('show/new.html.twig', [
                'show' => $show,
                'form' => $form->createView(),
            ]);
        }

    /**
     * @Route("/{id}", name="show_show", methods="GET")
     */
    public function show(Show $show): Response
    {

        return $this->render('show/show.html.twig', ['show' => $show]);
    }

    /**
     * @Route("/{id}/edit", name="show_edit", methods="GET|POST")
     */
    public function edit(Request $request, Show $show): Response
    {
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_edit', ['id' => $show->getId()]);
        }

        return $this->render('show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_delete", methods="DELETE")
     */
    public function delete(Request $request, Show $show): Response
    {
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($show);
            $em->flush();
        }

        return $this->redirectToRoute('show_index');
    }





    /* *
     * @Route("/{id}/pdf", name="pdf_diploma")
     */
//    public function pdf(Request $request): Response
//    {
//        $snappy = $this->get('knp_snappy.pdf');
//
//        $html = $this->renderView('show/diploma_pdf.html.twig', [
////            'registration' => $registration,
//        ]);
//
//        $filename = 'registration_pdf';
//
//
//
//        return new Response(
//            $snappy->getOutputFromHtml($html),
//            200,
//            array(
//                'Content-Type'          => 'application/pdf',
//                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
//            )
//        );
//    }
}
