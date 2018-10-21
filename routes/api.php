<?php

$app->post('/users/authenticate', 'ApiAuthController:authenticate');

$app->get('/admin/paymentmethods', 'PaymentmethodController:getPaymentMethod');
$app->post('/admin/paymentmethod', 'PaymentmethodController:postPaymentMethod');
$app->put('/admin/paymentmethod', 'PaymentmethodController:putPaymentMethod');
$app->delete('/admin/paymentmethod/{id}', 'PaymentmethodController:deletePaymentMethod');

$app->get('/admin/setting', 'SettingController:getSetting');
$app->put('/admin/setting', 'SettingController:putSetting');

$app->get('/admin/categories', 'CategoryController:getCategory');
$app->get('/admin/rootcategories', 'CategoryController:getRootCategory');
$app->post('/admin/category', 'CategoryController:postCategory');
$app->put('/admin/category', 'CategoryController:putCategory');
$app->delete('/admin/category/{id}', 'CategoryController:deleteCategory');
$app->post('/admin/category/uploadphoto', 'CategoryController:postCategoryPhoto');

$app->get('/admin/contents', 'ContentController:getContent');
$app->post('/admin/content', 'ContentController:postContent');
$app->put('/admin/content', 'ContentController:putContent');
$app->delete('/admin/content/{id}', 'ContentController:deleteContent');


$app->get('/admin/outlets', 'OutletController:getOutlet');
$app->post('/admin/outlet', 'OutletController:postOutlet');
$app->put('/admin/outlet', 'OutletController:putOutlet');
$app->delete('/admin/outlet/{id}', 'OutletController:deleteOutlet');


$app->get('/admin/banners', 'BannerController:getBanner');
$app->post('/admin/banner/uploadbanner', 'BannerController:postUploadImageAndAddRecord');
$app->put('/admin/banner', 'BannerController:putBanner');
$app->delete('/admin/banner/{id}', 'BannerController:deleteBanner');
$app->post('/admin/banner/reorder', 'BannerController:prepareAndReorder');

$app->get('/admin/infoboxes', 'InfoboxController:getInfobox');
$app->post('/admin/infobox', 'InfoboxController:postInfobox');
$app->put('/admin/infobox', 'InfoboxController:putInfobox');
$app->delete('/admin/infobox/{id}', 'InfoboxController:deleteInfobox');

$app->get('/admin/messages', 'MessageController:getMessage');
$app->post('/admin/message', 'MessageController:postMessage');
$app->put('/admin/message', 'MessageController:putMessage');
$app->delete('/admin/message/{id}', 'MessageController:deleteMessage');