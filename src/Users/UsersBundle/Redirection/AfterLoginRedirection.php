<?php
/**
 * Created by PhpStorm.
 * User: virga
 * Date: 2018-07-14
 * Time: 10:30
 */

namespace App\Users\UsersBundle\Redirection;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    /**
     * AfterLoginRedirection constructor.
     * @param Router $router
     * @param AuthorizationChecker $security
     */
    public function __construct(Router $router, AuthorizationChecker $security)
    {
        $this->router = $router;
        $this->security = $security;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($this->security->isGranted('ROLE_ADMIN') ) {
            $response = new RedirectResponse($this->router->generate('admin'));
        } else {
            $referer_url = $request->headers->get('referer');

            $response = new RedirectResponse($referer_url);
        }
        return $response;
    }
}