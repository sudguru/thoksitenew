<?php

$container['validator'] = function($container) {
    return new App\Validation\Validator;
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container) {
    return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function($container) {
    return new \App\Controllers\Auth\PasswordController($container);
};

$container['csrf'] = function($container) {
    return new \Slim\Csrf\Guard;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
// $app->add(new \App\Middleware\CsrfViewMiddleware($container));
// $app->add($container->csrf);

//Account
$container['DashboardController'] = function($container) {
    return new \App\Controllers\Account\DashboardController($container);
};

$container['AccountInfoController'] = function($container) {
    return new \App\Controllers\Account\AccountInfoController($container);
};

$container['ProductController'] = function($container) {
    return new \App\Controllers\Account\ProductController($container);
};