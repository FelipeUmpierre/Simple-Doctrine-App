<?php

namespace Configurations;

use Plasticbrain\FlashMessages\FlashMessages;

/**
 * Class ConfigurationsTrait
 *
 * @package Configurations
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
trait ConfigurationsTrait
{
    use SessionTrait;

    /**
     * Create the twig instance
     *
     * @return \Twig_Environment
     */
    public function twig()
    {
        $loader = new \Twig_Loader_Filesystem("src/Views");

        $twig = new \Twig_Environment($loader, ["debug" => true]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addGlobal("route", Routes::get());
        $twig->addGlobal("message", new FlashMessages());
        $twig->addGlobal("userSession", $this->getSession("user"));

        return $twig;
    }
}