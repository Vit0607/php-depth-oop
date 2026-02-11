<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if( !session_id() ) {
    session_start();
}

require '../vendor/autoload.php';


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users', ['App\Controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['App\Controllers\HomeController', 'about']);
    $r->addRoute('GET', '/verification', ['App\Controllers\HomeController', 'email_verification']);
    $r->addRoute('GET', '/login', ['App\Controllers\HomeController', 'login']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo '404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Метод не разрешён';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = new $handler[0];

        call_user_func([$controller, $handler[1]], $vars);
        // ... call $handler with $vars
        break;
}

function get_user_handler($vars) {
    d($vars['id']);
}