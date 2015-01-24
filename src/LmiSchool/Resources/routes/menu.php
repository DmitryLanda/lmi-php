<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->add('admin.menu.edit', '/admin/menu/{id}')
    ->setValues([
        'controller' => 'MenuController',
        'action' => 'editAction'
    ])
    ->setTokens(['id' => '\d+']);

$router->add('admin.menu.add', '/admin/menu/add')
    ->setValues([
        'controller' => 'MenuController',
        'action' => 'addAction'
    ]);

$router->add('admin.menu.list', '/admin/menu')
    ->setValues([
        'controller' => 'MenuController',
        'action' => 'listAction'
    ]);
