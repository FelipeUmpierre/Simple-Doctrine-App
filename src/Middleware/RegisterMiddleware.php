<?php

namespace Middleware;

use Configurations\Routes;
use Configurations\SessionTrait;
use Plasticbrain\FlashMessages\FlashMessages;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegisterMiddleware
 *
 * @package Middleware
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class RegisterMiddleware implements Middleware
{
    use SessionTrait;

    public static function validate()
    {
        $request = Request::createFromGlobals();

        $error = self::validateCredentials($request);

        if (!empty($error)) {
            $flash = new FlashMessages();
            $flash->error($error);

            // set the session for the content of the post
            // to be accessed in the view after the redirect
            self::setSession("signup", $request->request->all());

            $redirect = new RedirectResponse(Routes::get("signup"));
            $redirect->send();
            exit;
        }
    }

    /**
     * Validate credentials, email and password
     *
     * @param Request $request
     * @return array
     */
    public function validateCredentials(Request $request)
    {
        $error = [];

        // password validation
        // verify if the password is empty
        // verify if the confirm_password is empty
        // verify if the password and confirm_password are equal
        if (empty($request->request->get("password"))) {
            $error[] = "Password is required.";
        } else {
            if (empty($request->request->get("confirm_password"))) {
                $error[] = "You must confirm your password.";
            } else {
                if ($request->request->get("password") !== $request->request->get("confirm_password")) {
                    $error[] = "Password and confirmation are not the same.";
                }
            }
        }

        return $error;
    }
}