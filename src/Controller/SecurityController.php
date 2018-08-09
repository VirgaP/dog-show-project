<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-07-04
 * Time: 17:21
 */

namespace App\Controller;



use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /* *
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        $form = $this->createForm(LoginType::class);
        return $this->render('security/login.html.twig', [
            'login_form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        return $this->redirectToRoute('home');
    }
}