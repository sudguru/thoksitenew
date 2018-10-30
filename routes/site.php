<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\CsrfViewMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() {
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container))->add(new CsrfViewMiddleware($container))->add($container->csrf);

$app->group('', function() {
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
    $this->get('/account/info', 'AccountInfoController:getAccountInfo')->setName('account.info');
    $this->post('/account/info', 'AccountInfoController:updateAccountInfo');
})->add(new AuthMiddleware($container))->add(new CsrfViewMiddleware($container))->add($container->csrf);

$app->group('', function() {
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    $this->get('/account/dashboard', 'DashboardController:index')->setName('account.dashboard');  
    $this->get('/account/addresses', 'AccountInfoController:getAddresses')->setName('account.addresses');
    $this->post('/account/uploadlogo', 'AccountInfoController:uploadLogo');
    $this->get('/account/product/new', 'ProductController:getNewProduct')->setName('account.product.new');

})->add(new AuthMiddleware($container));


$app->get('/cart', 'CartController:getCart');
$app->post('/cart', 'CartController:postCart');
$app->put('/cart', 'CartController:updateCart');
$app->delete('/cart/{id}', 'CartController:deleteCart');


