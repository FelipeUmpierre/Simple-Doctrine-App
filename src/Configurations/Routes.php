<?php

namespace Configurations;

/**
 * Class Routes
 *
 * @package Configurations
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
abstract class Routes
{
    static private $routes = [
        "index" => "/",
        "search" => "/search",

        // register
        "signup" => "/signup",
        "register" => "/signup/register",

        // login
        "login" => "/login",
        "auth" => "/login/auth",
        "logout" => "/login/logout",

        // error pages
        "404" => "/404",
        "error" => "/error"
    ];

    /**
     * Return the route by name or the full array
     *
     * @param null $route
     * @return array
     */
    public static function get($route = null)
    {
        if (!is_null($route)) {
            return static::$routes[$route];
        }

        return static::$routes;
    }
}