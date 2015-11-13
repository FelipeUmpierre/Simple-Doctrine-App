<?php

namespace Controller;

use Configurations\Routes;
use Connection\DatabaseSingleton;
use Entity\User;
use Facade\UserFacade;
use Doctrine\ORM\NoResultException;
use Plasticbrain\FlashMessages\FlashMessages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class LoginController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class LoginController extends BaseController
{
    public function index()
    {
        $response = new Response();
        $response->setContent(
            $this->twig()->render("login/index.html.twig")
        );

        $response->send();
    }

    /**
     * Authentication auth
     *
     * @see \Middleware\LoginMiddleware
     */
    public function auth()
    {
        $request = Request::createFromGlobals();
        $userFacade = new UserFacade(DatabaseSingleton::getInstance());

        $user = new User();
        $user->setEmail($request->request->get("email"));

        try {
            $auth = $userFacade->auth($request->request->get("password"), $user);

            $this->setSession("user", $auth);

            $redirect = new RedirectResponse(Routes::get("index"));
        } catch (NoResultException $e) {
            $flash = new FlashMessages();
            $flash->error("E-mail or password are incorrect.");

            $redirect = new RedirectResponse(Routes::get("login"));
        }

        $redirect->send();
    }

    /**
     * Logout action
     */
    public function logout()
    {
        $this->removeSession("user");

        $redirect = new RedirectResponse(Routes::get("index"));
        $redirect->send();
    }
}