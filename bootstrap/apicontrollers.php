<?php

$container['ApiAuthController'] = function($container) {
    return new \App\Controllers\Admin\ApiAuthController($container);
};

$container['PaymentmethodController'] = function($container) {
    return new \App\Controllers\Admin\PaymentmethodController($container);
};

$container['SettingController'] = function($container) {
    return new \App\Controllers\Admin\SettingController($container);
};

$container['CategoryController'] = function($container) {
    return new \App\Controllers\Admin\CategoryController($container);
};

$container['ContentController'] = function($container) {
    return new \App\Controllers\Admin\ContentController($container);
};

$container['OutletController'] = function($container) {
    return new \App\Controllers\Admin\OutletController($container);
};

$container['BannerController'] = function($container) {
    return new \App\Controllers\Admin\BannerController($container);
};

$container['InfoboxController'] = function($container) {
    return new \App\Controllers\Admin\InfoboxController($container);
};

$container['MessageController'] = function($container) {
    return new \App\Controllers\Admin\MessageController($container);
};
