<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\DiplomaRepository;
use App\Repository\RegistrationRepository;
use App\Services\FileUploader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Asset\Packages;


/**
 * @Route("/registration")
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/member/{page}", defaults={"page" = 1}, name="member_registration_index", methods="GET")
     * @ Security("is_granted('ROLE_USER')")
     */
    public function userRegistrations($page, RegistrationRepository $registrationRepository): Response
    {
        $user = $this->getUser();
        $owner = $user->getOwner();
        $paginator = $registrationRepository->getAllByUser($page, $owner);
        $registrations = $paginator->getIterator();
//        if (count($registrations) == 0) {
//            throw new NotFoundHttpException('404. Page not found');
//        }
        $maxPages = ceil($paginator->count() / RegistrationRepository::POSTS_PER_PAGE);
        $currentPage = $page;
        $routeName = 'member_registration_index';
        return $this->render('registration/index.html.twig',
            compact('registrations', 'maxPages', 'currentPage', 'routeName') );


    }

    /**
     * @Route("/index/{page}", defaults={"page" = 1}, name="registration_index", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index($page, RegistrationRepository $registrationRepository): Response
    {
        $paginator = $registrationRepository->getAllRegistrations($page);
        $registrations = $paginator->getIterator();

        if (count($registrations) == 0) {
            throw new NotFoundHttpException('404. Page not found');
        }
        $maxPages = ceil($paginator->count() / RegistrationRepository::POSTS_PER_PAGE);
        $currentPage = $page;
        $routeName = 'registration_index';

        return $this->render('registration/index.html.twig',compact('registrations', 'maxPages', 'currentPage', 'routeName') );
    }

    /**
     * @Route("/new", name="registration_new", methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $registration = new Registration();
        $user = $this->getUser();
        $owner= $user->getOwner();
        $form = $this->createForm(RegistrationType::class, $registration, array(
            'owner' => $owner, //passing $owner variable to RegistrationFormtype form querybuilder
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($form->getData()->getFiles() as $file) {

                if ($file != null) {
                    $fileName = $fileUploader->upload($file->getFile());//upload retrieves instnce of uploaded file from service upload method
                    $file->setFileName($fileName);
                }

            }
            $registration->setIsConfirmed(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();
            $this->addFlash('success',
                'Your entry to show is successfully saved! You will receive email confirmation shortly / Registracija į parodą pateikta sėkmingai. Laukite patrvirtinimo el. paštu.');


            return $this->redirectToRoute('fos_user_profile_show');
        }
                return $this->render('registration/new.html.twig', [
                    'registration' => $registration,
                    'form' => $form->createView(),
                ]);
    }

    /**
     * @Route("/{id}", name="registration_show", methods="GET")
     */
    public function show(Registration $registration): Response
    {
        $this->denyAccessUnlessGranted('see', $registration);
        return $this->render('registration/show.html.twig', ['registration' => $registration]);
    }

    /**
     * @Route("/{id}/edit", name="registration_edit", methods="GET|POST")
     */
    public function edit(Request $request, Registration $registration, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('edit', $registration);
        $user = $this->getUser();
        $owner= $user->getOwner();
        $form = $this->createForm(RegistrationType::class, $registration, [
            'update' => true,
            'label' => 'Update',
            'is_edit' => true,
            'owner' => $owner,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($form->getData()->getFiles() as $file) {

                if ($file != null && $file->getFile() !=null) {
                    $fileName = $fileUploader->upload($file->getFile());//upload retrieves instnace of uploaded file from FileUploader service upload method
                    $file->setFileName($fileName);
                }
            }
            $evm = new EventManager();//used to disptach ORM events
            $em = $this->getDoctrine()->getManager();
            $eventArgs = new LifecycleEventArgs($registration, $em);
            $evm->dispatchEvent(\Doctrine\ORM\Events::preUpdate, $eventArgs);

            $em->persist($registration);
            $em->flush();
            $this->addFlash('success',
                'Information successfuly updated/ Informacija sėkmingai atnaujinta.');


            return $this->redirectToRoute('registration_show', ['id' => $registration->getId()]);
        }

        return $this->render('registration/edit.html.twig', [
            'registration' => $registration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="registration_delete", methods="DELETE")
     */
    public function delete(Request $request, Registration $registration): Response
    {
        $this->denyAccessUnlessGranted('delete', $registration);

        if ($this->isCsrfTokenValid('delete'.$registration->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registration);
            $em->flush();
        }

        return $this->redirectToRoute('member_registration_index');
    }


    /**
     * @Route("/{id}/pdf", name="pdf_example")
     */
    public function pdf(Request $request, Registration $registration): Response
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('registration/regpdf.html.twig', [
            'registration' => $registration,
            ]);

        $filename = 'registration_pdf';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    /**
     * @Route("/{id}/card_pdf", name="card_pdf")
     */
    public function cardPdf(Request $request, Registration $registration, Packages $assetPackage): Response
    {
        $snappy = $this->get('knp_snappy.pdf');
        $path = $request->server->get('DOCUMENT_ROOT');    // C:/wamp64/www/
        $path = rtrim($path, "/");                         // C:/wamp64/www

        $webPath = $this->get('kernel')->getProjectDir() . '/assets/images/card_header.png';
        $image = file_get_contents($webPath);
        $image_encoded=base64_encode($image);
        $html = $this->renderView('registration/card_pdf.html.twig', [
            'registration' => $registration,
            'path'=>$path,
            'image_encoded' => $image_encoded
        ]);



        $filename = 'card';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"',
            )
        );
    }


    public function myAction(Packages $assetPackage)
    {
        $url = $assetPackage->getUrl('images/card_header.a2914c8e.png');
        var_dump($url);
        exit;
    }

}
