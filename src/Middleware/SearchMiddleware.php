<?php

namespace Middleware;

use Configurations\Routes;
use Configurations\SessionTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchMiddleware
 *
 * @package Middleware
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class SearchMiddleware implements Middleware
{
    use SessionTrait;

    /**
     * Validate the search request
     */
    public static function validate()
    {
        $request = new Request();

        if (empty($request->request->get("search")) || !self::hasSession("user")) {
            $redirect = new RedirectResponse(Routes::get("index"));
            $redirect->send();
            exit;
        }
    }
}