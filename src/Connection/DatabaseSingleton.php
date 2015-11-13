<?php

namespace Connection;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Yaml\Parser;

/**
 * Class DatabaseSingleton
 *
 * @package Connection
 * @author Felipe Pieretti Umpierre <umpierre.felipe[at]gmail.com>
 */
final class DatabaseSingleton
{
    /**
     * @var EntityManager
     */
    private static $instance;

    /**
     * @var array
     */
    private static $paths = ["src/Entity"];

    /**
     * @var bool
     */
    private static $isDevMode = false;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *DatabaseSingleton* via the `new` operator from outside of this class.
     */
    private function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *DatabaseSingleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *DatabaseSingleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * Returns the *Singleton* instance of the EntityManager.
     *
     * @return EntityManager
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = static::configuration();
        }

        return static::$instance;
    }


    /**
     * Start the connection with the database
     */
    private static function configuration()
    {
        $yaml = new Parser();
        $databaseConfiguration = $yaml->parse(file_get_contents(__DIR__ . "/../../config/database.yml"));

        $config = Setup::createConfiguration(static::$isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), static::$paths);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader("class_exists");

        $config->setMetadataDriverImpl($driver);

        return EntityManager::create($databaseConfiguration["database"], $config);
    }
}