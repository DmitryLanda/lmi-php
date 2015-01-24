<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->add('home', '/')
    ->setValues(array(
        'controller' => 'IndexController',
        'action' => 'indexAction'
    ));
$router->attach('error', '/error', function($router) {
    $router->add('not_found', '/404')
        ->setValues(array(
            'controller' => 'ErrorController',
            'action' => 'notFoundAction'
        ));
    $router->add('not_authorized', '/403')
        ->setValues(array(
            'controller' => 'ErrorController',
            'action' => 'notAuthorizedAction'
        ));
});

$router->add('admin.login', '/admin/login')
    ->setValues([
        'controller' => 'LoginController',
        'action' => 'loginAction'
    ]);

$router->add('admin.logout', '/admin/logout')
    ->setValues([
        'controller' => 'LoginController',
        'action' => 'logoutAction'
    ])
    ->setMethod('GET');

include __DIR__ . '/routes/news.php';
include __DIR__ . '/routes/teachers.php';
include __DIR__ . '/routes/pages.php';
include __DIR__ . '/routes/documents.php';
include __DIR__ . '/routes/menu.php';
