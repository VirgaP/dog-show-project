<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Repository\OwnerRepository;
use FOS\UserBundle\Model\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/member")
 */
class OwnerController extends Controller
{
    /**
     * @Route("/index", name="member_index", methods="GET")
     */
    public function index(OwnerRepository $ownerRepository)
    {
        return $this->render('owner/index.html.twig', [
            'owners' => $ownerRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="member_registration", methods="GET|POST")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function new(Request $request): Response
    {
        $owner = new Owner();
        $user = $this->getUser();
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $owner->setUser($user);
            $em->persist($owner);
            $em->flush();
            $this->addFlash('success', "Profile created/Anketa sukurta.");

//            return $this->redirectToRoute('member_show', ['id' => $owner->getId()]);
            return $this->redirectToRoute('fos_user_profile_show');

        }

        return $this->render('owner/new.html.twig', [
            'owner' => $owner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_show", methods="GET")
     */
    public function show(Owner $owner): Response
    {
        return $this->render('owner/show.html.twig', [
            'owner' => $owner,
            'user'=> $user = $this->getUser()->getEmail()

        ]);
    }


    /**
     * @Route("/{id}/edit", name="member_edit", methods="GET|POST")
     */
    public function edit(Request $request, Owner $owner): Response
    {
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Information updated successfuly/Duomenys atnaujinti.");

            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('owner/edit.html.twig', [
            'owner' => $owner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods="DELETE")
     */
    public function delete(Request $request, Owner $owner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$owner->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($owner);
            $em->flush();
        }

        return $this->redirectToRoute('owner_index');
    }

}
