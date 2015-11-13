<?php

namespace Controller;

use Configurations\Routes;
use Connection\DatabaseSingleton;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Entity\User;
use Facade\UserFacade;
use Plasticbrain\FlashMessages\FlashMessages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SignupController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class SignupController extends BaseController
{
    /**
     * Index action
     */
    public function index()
    {
        $response = new Response();
        $response->setContent(
            $this->twig()->render("signup/index.html.twig", [
                "signupSession" => $this->removeSession("signup")
            ])
        );

        $response->send();
    }

    /**
     * Register action
     */
    public function register()
    {
        $request = Request::createFromGlobals();
        $userFacade = new UserFacade(DatabaseSingleton::getInstance());

        $user = new User();
        $user->setName($request->request->get("name"));
        $user->setEmail($request->request->get("email"));
        $user->setPassword($request->request->get("password"));
        $user->setCountry($request->request->get("country"));

        try {
            $userFacade->save($user);

            $redirect = new RedirectResponse(Routes::get("login"));
        } catch (UniqueConstraintViolationException $e) {
            $flash = new FlashMessages();
            $flash->error("E-mail is already registered.");

            $this->setSession("signup", $request->request->all());

            $redirect = new RedirectResponse(Routes::get("signup"));
        }

        $redirect->send();
    }
}