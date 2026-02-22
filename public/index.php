<?php

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', 1);

if( !session_id() ) {
    session_start();
}

require '../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/views');
    },

    PDO::class => function() {
        $driver = "mysql";
        $host = "MySQL-8.4";
        $database_name = "app3";
        $username = "root";
        $password = "";

        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },

    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    },

    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    }
]);
$container = $builder->build();

$faker = Faker\Factory::create();

$pdo = new PDO("mysql:host=MySQL-8.4;dbname=app3;charset=utf8", "root", "");
$queryFactory = new QueryFactory('mysql');

// $insert = $queryFactory->newInsert();

// // insert into this table
// $insert->into('posts');

// for ($i=0; $i < 30; $i++) {
//     $insert->cols([
//         'title' => $faker->words(3, true),
//         'content' => $faker->text()
//     ]);
//     $insert->addRow();
// }

// $sth = $pdo->prepare($insert->getStatement());
// $sth->execute($insert->getBindValues());


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\Controllers\HomeController', 'index']);
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

        $container->call($routeInfo[1], $routeInfo[2]);
        // ... call $handler with $vars
        break;
}

function get_user_handler($vars) {
    d($vars['id']);
}

?>