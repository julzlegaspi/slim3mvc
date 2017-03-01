<?php
session_start();
include __DIR__ . '/vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

//Database setup
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'slim-demo',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

//Get Slim container
$container = $app->getContainer();

//Register csrf on container
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

//Register flash on container
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

//add csrf to all routes
$app->add($container->get('csrf'));

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__. '/views', [
        'cache' => false,
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new App\Extension\CsrfExtension($container['csrf']));
    //$view->getEnvironment()->addGlobal('sessionid', isset($_SESSION['userid']) ? $_SESSION['userid'] : '');
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};

//register every controller name here
$container['TodoController'] = function($container) {
    return new \App\Controllers\TodoController($container);
};

include __DIR__ . '/app/routes.php';

$app->run();