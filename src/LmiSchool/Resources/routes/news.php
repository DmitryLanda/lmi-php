<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->attach('news', '/news', function($router) {
    $router->add('list', '/page/{page}')
        ->setValues(array(
            'controller' => 'NewsController',
            'action' => 'listAction'
        ))
        ->addValues(['page' => 1]);

    $router->add('show', '/{id}')
        ->setValues(array(
            'controller' => 'NewsController',
            'action' => 'showAction'
        ));

    $router->add('add', '/add')
        ->setValues(array(
            'controller' => 'NewsController',
            'action' => 'addAction'
        ));

    $router->add('remove', '/{id}/remove')
        ->setValues(array(
            'controller' => 'NewsController',
            'action' => 'removeAction'
        ));

    $router->add('edit', '/{id}/edit')
        ->setValues(array(
            'controller' => 'NewsController',
            'action' => 'editAction'
        ));
});
