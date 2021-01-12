<?php

/**
 * Front controller
 * 
 * Handles all requests and routes
 * the request to the corresponding
 * controller / action.
 */


// Composer auto loader
require dirname(__DIR__) . '/vendor/autoload.php';

// Error and Exception handling
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

// Enable routing 
$router = new Core\Router();

// Add routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}', ['action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

// Execute action method according to the route
$router->dispatch($_SERVER['QUERY_STRING']);