<?php

namespace Middleware;

use Configurations\Routes;
use Plasticbrain\FlashMessages\FlashMessages;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginMiddleware
 *
 * @package Middleware
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class LoginMiddleware implements Middleware
{
    /**
     * Validate the fields, if they are not empty
     * If the fields are empty, redirect to login form
     */
    public static function validate()
    {
        $request = Request::createFromGlobals();

        if (empty($request->request->get("email")) || empty($request->request->get("password"))) {
            $flash = new FlashMessages();
            $flash->error("Both fields are required.");

            $redirect = new RedirectResponse(Routes::get("login"));
            $redirect->send();
            exit;
        }
    }
}