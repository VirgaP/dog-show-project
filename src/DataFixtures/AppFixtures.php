<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-29
 * Time: 22:28
 */

namespace App\DataFixtures;


use App\Entity\ShowClass;
use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
//       $this->setContainer($container);
        $this->container=$container;
    }
    public function load(ObjectManager $manager)
    {
        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail(' bulldogclub.lt@gmail.com');
        $user->setPlainPassword('paroda_2018');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));

        // Update the user
        $userManager->updateUser($user, true);
    }
}

//        $classes = ['Baby (4-6 months)/ Šuniukų (nuo 4 iki 6 mėnesių)',
//            'Puppy (6-9 months) / Mažylių	(nuo 6 iki 9 mėnesių)',
//            'Junior (9-18 months) /Jaunimo	(nuo 9 iki 18 mėnesių)',
//            'Intermediate (15-24 months) / Pereinamoji (nuo 15 iki 24 mėnesių)',
//            'Open (from 15 months) / Atviroji (nuo 15 mėnesių)',
//            'Champion (from 15 months) / Čempionų (nuo 15 mėnesių)',
//            'Club champion (from 15 months) / Klubo čempionų (nuo 15 mėnesių)',
//            'Veteran (from 8 years) / Veteranų	(nuo 8 metų)'];
//        for ($i = 0; $i < count($classes); $i++) {
//            $showClass = new ShowClass();
//            $showClass->setClassTitle($i);
//            $manager->persist($showClass);
//        }