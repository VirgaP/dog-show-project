<?php

namespace App\Controller;

use App\Entity\Home;
use App\Entity\Registration;
use App\Events;
use App\Form\HomeType;
use App\Repository\RegistrationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function persistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }

    /**
     * @Route("/admin/registrations", name="pending_registrations_index")
     */
    public function comments(RegistrationRepository $registrationRepository)
    {
        return $this->render('admin/registrations.html.twig', ['registrations' => $registrationRepository->findAllWhereNotConfirmed()]);
    }

    /**
     * @Route("/admin/registration/{id}/confirm", name="registration_confirm")
     * @throws \Doctrine\ORM\ORMException
     */
    public function confirm(Registration $registration, RegistrationRepository $registrationRepository, EventDispatcherInterface $eventDispatcher)
    {
        $registrationRepository->setAsIsConfirmed($registration->getId());
        $event = new GenericEvent($registration);

        $eventDispatcher->dispatch(Events::REGISTRATION_CONFIRMED, $event);


        $this->addFlash('success', "Registracija patvirtinta");

        return $this->redirectToRoute('pending_registrations_index');
    }



}
