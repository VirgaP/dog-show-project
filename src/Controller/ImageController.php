<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\Image1Type;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Services\FileUploader;
use http\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ImageController extends Controller
{
    /**
     * @Route("admin/file", name="file_index", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll()
        ]);
    }

    /**
     * @Route("/api/downloadfile/{id}")
     */
    public function downloadAction($id) {
        try {
            $file = $this->getDoctrine ()->getRepository ( Image::class )->find ( $id );
            if (! $file) {
                $array = array (
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ( $array, 200 );
                return $response;
            }
            $fileName = $file->getFileName ();
            $file_with_path = $this->container->getParameter ( 'images_directory' ). $fileName;
            $response = new BinaryFileResponse ( $file_with_path );
            $response->headers->set ( 'Content-Type', 'text/plain' );
            $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT );
            return $response;
        } catch ( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }

    /**
     * @Route("/admin/file/new", name="file_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('file_index');
        }

        return $this->render('image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/file/{id}", name="file_show", methods="GET")
     */
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', ['image' => $image]);
    }

    /**
     * @Route("/admin/file/{id}/edit", name="file_edit", methods="GET|POST")
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_edit', ['id' => $image->getId()]);
        }

        return $this->render('image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/file/{id}", name="image_delete", methods="DELETE")
     */
    public function delete(Request $request, Image $image, ImageRepository $imageRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }
//
//            $fs = new Filesystem();
//            $fs->remove($this->get('kernel')->getRootDir().'/../public/uploads/images/'.$image); //deletes entire images sudirectory

        $fs = new Filesystem();
//        $dirpath =  $this->container->get('kernel')->getRootDir() . '/../public/uploads/images/';
        $dirpath = $this->getParameter('images_directory');
        $fileName=$image->getFileName();
        $full_path = $dirpath.$fileName;

        $fs->remove($full_path);


        return $this->redirectToRoute('file_index');
    }
}
