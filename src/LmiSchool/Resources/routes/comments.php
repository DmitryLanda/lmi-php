<?php
/** @var \Aura\Router\Router|\Aura\Router\RouteCollection $router */

$router->attach('comments', '/comments', function($router) {
    $router->add('list', '?{options}')
        ->setValues(array(
            'controller' => 'CommentController',
            'action' => 'listAction'
        ));
    $router->add('add', '/add')
        ->setValues(array(
            'controller' => 'CommentController',
            'action' => 'addAction'
        ));
    $router->add('captcha', '/get-captcha')
        ->setValues(array(
            'controller' => 'CommentController',
            'action' => 'getCaptchaAction'
        ));
});
