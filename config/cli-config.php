<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

return ConsoleRunner::createHelperSet(\Connection\DatabaseSingleton::getInstance());