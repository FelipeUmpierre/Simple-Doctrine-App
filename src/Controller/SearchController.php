<?php

namespace Controller;

use Connection\DatabaseSingleton;
use Facade\UserFacade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 *
 * @package Controller
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
class SearchController extends BaseController
{
    /**
     * Search action
     */
    public function search()
    {
        $userFacade = new UserFacade(DatabaseSingleton::getInstance());

        $request = Request::createFromGlobals();
        $search = $request->request->all();

        $response = new Response();
        $response->setContent(
            $this->twig()->render("index/index.html.twig", [
                "users" => $userFacade->search($search),
                "search" => $search["search"]
            ])
        );

        $response->send();
    }
}