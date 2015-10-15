<?php

use Airbrake\ErrorHandler;
use Airbrake\Instance;
use Airbrake\Notifier;
use Zend\Mvc\Application;

date_default_timezone_set('Europe/London');

chdir(dirname(__DIR__));

// Composer autoloading
if (!include_once('vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

// Get application stack configuration
$config = include 'config/application.config.php';

// Create new Notifier instance.
$notifier = new Notifier([
    'projectId' => 116732,
    'projectKey' => '20c3949e27b50d1921dcd377a5f1851a',
]);

// Set global notifier instance.
Instance::set($notifier);

// Register error and exception handlers.
$handler = new ErrorHandler($notifier);
$handler->register();

Application::init($config)->run();
