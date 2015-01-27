<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->add('page.show', '/{slug}')
    ->setValues([
        'controller' => 'PageController',
        'action' => 'showAction'
    ])
    ->setTokens([
        'slug' => '(?!admin|teachers|news|error|documents|comments)+[^/]+'
    ])
    ->setWildcard('slugs');

$router->add('admin.page.edit', '/admin/{id}')
    ->setValues([
        'controller' => 'PageController',
        'action' => 'editAction'
    ])
    ->setTokens(['id' => '\d+'])
    ->setMethod('GET');

$router->add('admin.page.add', '/admin/add-page')
    ->setValues([
        'controller' => 'PageController',
        'action' => 'addAction'
    ]);

$router->add('admin.page.update', '/admin/{id}')
    ->setValues([
        'controller' => 'PageController',
        'action' => 'updateAction'
    ])
    ->setTokens(['id' => '\d+'])
    ->setMethod('POST');

$router->add('admin.page.list', '/admin')
    ->setValues([
        'controller' => 'PageController',
        'action' => 'listAction'
    ]);
