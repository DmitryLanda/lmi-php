<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */


$router->attach('teachers', '/teachers', function($router) {
    $router->add('list', '/page/{page}')
        ->setValues(array(
            'controller' => 'TeacherController',
            'action' => 'listAction'
        ))
        ->addValues(['page' => 1]);

    $router->add('show', '/{id}')
        ->setValues(array(
            'controller' => 'TeacherController',
            'action' => 'showAction'
        ));

    $router->add('add', '/add')
        ->setValues(array(
            'controller' => 'TeacherController',
            'action' => 'addAction'
        ));

    $router->add('remove', '/{id}/remove')
        ->setValues(array(
            'controller' => 'TeacherController',
            'action' => 'removeAction'
        ));

    $router->add('edit', '/{id}/edit')
        ->setValues(array(
            'controller' => 'TeacherController',
            'action' => 'editAction'
        ));
});
