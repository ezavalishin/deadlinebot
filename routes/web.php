<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'vk-callback', 'middleware' => 'vk-callback-auth'], function () use ($router) {
    $router->post('/', 'VkCallbackController');
    $router->get('/', 'VkCallbackController');
});
