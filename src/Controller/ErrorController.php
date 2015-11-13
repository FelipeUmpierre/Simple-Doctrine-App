<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ErrorController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class ErrorController extends BaseController
{
    /**
     * Not Found action
     */
    public function notFound()
    {
        $response = new Response();
        $response->setContent(
            $this->twig()->render("error/404.html.twig")
        );

        $response->send();
    }

    /**
     * Others errors action
     */
    public function other()
    {
        $response = new Response();
        $response->setContent(
            $this->twig()->render("error/error.html.twig")
        );

        $response->send();
    }
}