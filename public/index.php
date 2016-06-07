<?php

use Zend\Mvc\Application;

date_default_timezone_set('Europe/London');

chdir(dirname(__DIR__));

// Composer autoloading
if (!include_once('vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

$client = new Raven_Client(getenv('RAVEN_URL'));

// Install error handlers and shutdown function to catch fatal errors
$error_handler = new Raven_ErrorHandler($client);
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();

// Get application stack configuration
$config = include 'config/application.config.php';

Application::init($config)->run();
