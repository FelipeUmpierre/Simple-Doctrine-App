<?php

namespace Configurations;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionTrait
 *
 * @package Configurations
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
trait SessionTrait
{
    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        $this->session = new Session();

        if ($this->session->getId() == null) {
            $this->session->start();
        }
    }

    /**
     * Create a new session with the name and value passed
     *
     * @param string $name
     * @param string|object|array $value
     */
    public function setSession($name, $value)
    {
        $this->session->set($name, $value);
    }

    /**
     * Return a session by the name
     *
     * @param string $name
     * @return mixed
     */
    public function getSession($name)
    {
        return $this->session->get($name);
    }

    /**
     * Verify if the session exists
     *
     * @param string $name
     * @return bool
     */
    public function hasSession($name)
    {
        return $this->session->has($name);
    }

    /**
     * Remove a session item and return the value of the session
     * before it is removed.
     *
     * @param $name
     * @return mixed
     */
    public function removeSession($name)
    {
        $currentSession = $this->getSession($name);

        $this->session->remove($name);

        return $currentSession ?: null;
    }
}