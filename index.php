<?php

require_once "vendor/autoload.php";

use MiladRahimi\PHPRouter\Router;
use MiladRahimi\PHPRouter\Exceptions\HttpError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Configurations\Routes;

$router = new Router();

$router->get(Routes::get("index"), "Controller\IndexController@index");
$router->post(Routes::get("search"), "Controller\SearchController@search", "Middleware\SearchMiddleware@validate");

$router->get(Routes::get("signup"), "Controller\SignupController@index");
$router->post(Routes::get("register"), "Controller\SignupController@register", "Middleware\RegisterMiddleware@validate");

$router->get(Routes::get("login"), "Controller\LoginController@index");
$router->post(Routes::get("auth"), "Controller\LoginController@auth", "Middleware\LoginMiddleware@validate");
$router->get(Routes::get("logout"), "Controller\LoginController@logout");

$router->get(Routes::get("404"), "Controller\ErrorController@notFound");
$router->get(Routes::get("error"), "Controller\ErrorController@other");

try {
    $router->dispatch();
} catch (HttpError $e) {
    if ($e->getMessage() == "404") {
        $redirect = new RedirectResponse(Routes::get("404"));
    } else {
        $redirect = new RedirectResponse(Routes::get("error"));
    }

    return $redirect->send();
}