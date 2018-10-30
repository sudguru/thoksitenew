<?php

namespace App\Controllers\Account;

use App\Models\Setting;
use App\Models\Infobox;
use App\Models\Message;
use App\Models\paymentmethod;
use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AccountInfoController extends Controller {
    

    public function getAccountInfo($request, $response) {
        $setting = Setting::first();
        $infoboxes = Infobox::orderBy('display_order')->limit(3)->get();
        $messages = Message::orderBy('display_order')->limit(10)->get();
        $payment_methods = Paymentmethod::orderBy('payment_method')->get();
        return $this->view->render($response, 'account/info.html', [
                'setting' => $setting,
                'infoboxes' => $infoboxes,
                'messages' => $messages,
                'available_payment_methods' => $payment_methods,
                'currentPage' => 'accountinfo'
            ]
        );
    }

    public function uploadLogo($request, $response) {
        // $this->logger->addInfo($request->getParam('imageDataURL'));

        $upload_dir = "../public/uploads/logos/";
        $id = $request->getParam('id');
        $photo = $request->getParam('imageDataURL');
        $filename = rand(10000, 99999) . '-' . $request->getParam('filename');
        $img = str_replace('data:image/png;base64,', '', $photo);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace('data:image/gif;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imagedata = base64_decode($img);
        $file = $upload_dir . $filename;
        $success = file_put_contents($file, $imagedata);
        if($success) {
            User::where('id', $id)->update([
                'logo' => $filename
            ]);
        }
        return $response->withJson($success);
    }

    public function updateAccountInfo($request, $response) {

        //var_dump($request->getParam('payment_methods'));
        //die();
        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
        ]);

        if($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('account.info'));
        }
        $id = $this->auth->user()->id;
        User::where('id', $id)->update([
            'name' => $request->getParam('name'),
            'company_name' => $request->getParam('company_name'),
            'address' => $request->getParam('address'),
            'shipping_address' => $request->getParam('shipping_address'),
            'city' => $request->getParam('city'),
            'shipping_city' => $request->getParam('shipping_city'),
            'state' => $request->getParam('state'),
            'shipping_state' => $request->getParam('shipping_state'),
            'postal_code' => $request->getParam('postal_code') ? $request->getParam('postal_code') : 0,
            'shipping_postal_code' => $request->getParam('shipping_postal_code')? $request->getParam('shipping_postal_code') : 0,
            'country' => $request->getParam('country'),
            'shipping_country' => $request->getParam('shipping_country'),
            'phone' => $request->getParam('phone'),
            'shipping_phone' => $request->getParam('shipping_phone'),
            'fax' => $request->getParam('fax'),
            'url' => $request->getParam('url'),
            'payment_methods' => "[" . implode(",", $request->getParam('payment_methods')) . "]",
            'bank_info' => $request->getParam('bank_info'),
            'description' => $request->getParam('description')
        ]);
        $this->flash->addMessage('success', 'Account Info Successfully Updated !');
        return $response->withRedirect($this->router->pathFor('account.info'));
    }
}