<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Setting;
use App\Controllers\Admin\Helper;

class SettingController extends Controller {


    public function getSetting($request, $response) {

        // $this->logger->addInfo($request->getParam('password'));

        $settings = Setting::first();
        $result = Helper::createApiResponse($settings);
        return $response->withJson($result);
        
    }


    public function putSetting($request, $response) {

        $data = $request->getParsedBody();
        $setting = $data['setting'];

        $id = filter_var($setting['id'], FILTER_SANITIZE_NUMBER_INT);
        $site_name = filter_var($setting['site_name'], FILTER_SANITIZE_STRING);
        $phone1 = filter_var($setting['phone1'], FILTER_SANITIZE_STRING);
        $phone2 = filter_var($setting['phone2'], FILTER_SANITIZE_STRING);
        $address = filter_var($setting['address'], FILTER_SANITIZE_STRING);
        $email = filter_var($setting['email'], FILTER_SANITIZE_STRING);
        $order_email = filter_var($setting['order_email'], FILTER_SANITIZE_STRING);
        $description = filter_var($setting['description'], FILTER_SANITIZE_STRING);
        $facebook = filter_var($setting['facebook'], FILTER_SANITIZE_STRING);
        $twitter = filter_var($setting['twitter'], FILTER_SANITIZE_STRING);
        $googleplus = filter_var($setting['googleplus'], FILTER_SANITIZE_STRING);
        $youtube = filter_var($setting['youtube'], FILTER_SANITIZE_STRING);
        $viber = filter_var($setting['viber'], FILTER_SANITIZE_STRING);
        $whatsapp = filter_var($setting['whatsapp'], FILTER_SANITIZE_STRING);
        $skype = filter_var($setting['skype'], FILTER_SANITIZE_STRING);

        $pm = Setting::where('id', $id)->update([
            'site_name' => $site_name,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'address' => $address,
            'email' => $email,
            'order_email' => $order_email,
            'description' => $description,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'googleplus' => $googleplus,
            'youtube' => $youtube,
            'viber' => $viber,
            'whatsapp' => $whatsapp,
            'skype' => $skype
        ]);
        $result = Helper::createApiResponse($pm);
        
        
        return $response->withJson($result);
    }


} 