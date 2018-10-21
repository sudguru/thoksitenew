<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Paymentmethod;
use App\Controllers\Admin\Helper;

class PaymentmethodController extends Controller {


    public function getPaymentMethod($request, $response) {

        // $this->logger->addInfo($request->getParam('password'));

        $paymentmethods = Paymentmethod::all();
        $result = Helper::createApiResponse($paymentmethods);
        return $response->withJson($result);
        
    }

    public function postPaymentMethod($request, $response) {

        $data = $request->getParsedBody();
        $paymentmethod = $data['paymentmethod'];
        $payment_method = filter_var($paymentmethod['payment_method'], FILTER_SANITIZE_STRING);

        $pm = Paymentmethod::create([
            'payment_method' => $payment_method
        ]);
        $result = Helper::createApiResponse($pm);
        return $response->withJson($result);
    }

    public function putPaymentMethod($request, $response) {

        $data = $request->getParsedBody();
        $paymentmethod = $data['paymentmethod'];
        $payment_method = filter_var($paymentmethod['payment_method'], FILTER_SANITIZE_STRING);
        $id = filter_var($paymentmethod['id'], FILTER_SANITIZE_NUMBER_INT);

        $pm = Paymentmethod::where('id', $id)->update([
            'payment_method' => $payment_method
        ]);
        $result = Helper::createApiResponse($pm);
        
        return $response->withJson($result);
    }

    public function deletePaymentMethod($request, $response, $args) {
        $id = $args['id'];

        $pm = Paymentmethod::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }
} 