<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class IndexController extends BaseController
{
    /**
     * Index action
     */
    public function index()
    {
        $response = new Response();
        $response->setContent(
            $this->twig()->render("index/index.html.twig")
        );

        $response->send();
    }
}