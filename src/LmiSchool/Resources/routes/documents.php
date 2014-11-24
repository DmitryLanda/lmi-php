<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->attach('documents', '/documents', function($router) {
    $router->add('list', '/page/{page}')
        ->setValues(array(
            'controller' => 'DocumentController',
            'action' => 'listAction'
        ))
        ->addValues(['page' => 1]);

    $router->add('show', '/{id}')
        ->setValues(array(
            'controller' => 'DocumentController',
            'action' => 'showAction'
        ));

    $router->add('download', '/{id}/download')
        ->setValues(array(
            'controller' => 'DocumentController',
            'action' => 'downloadAction'
        ));
});
