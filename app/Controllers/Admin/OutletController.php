<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Outlet;
use App\Controllers\Admin\Helper;


class OutletController extends Controller {


    public function getOutlet($request, $response) {
        
        $outlets = Outlet::orderBy('outlet')->get();
        $result = Helper::createApiResponse($outlets);
        return $response->withJson($result);
        
    }


    public function postOutlet($request, $response) {

        $data = $request->getParsedBody();
        $outlet = $data['outlet'];
        $outletname = filter_var($outlet['outlet'], FILTER_SANITIZE_STRING);
        $description = $outlet['description'];
        $contact_person = filter_var($outlet['contact_person'], FILTER_SANITIZE_STRING);
        $address = filter_var($outlet['address'], FILTER_SANITIZE_STRING);
        $phone = filter_var($outlet['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($outlet['email'], FILTER_SANITIZE_STRING);
        $viber = filter_var($outlet['viber'], FILTER_SANITIZE_STRING);
        $whatsapp = filter_var($outlet['whatsapp'], FILTER_SANITIZE_STRING);
        $skype = filter_var($outlet['skype'], FILTER_SANITIZE_STRING);
        $lat = filter_var($outlet['lat'], FILTER_SANITIZE_STRING);
        $lng = filter_var($outlet['lng'], FILTER_SANITIZE_STRING);
        if ( get_magic_quotes_gpc() )
            $description = htmlspecialchars( stripslashes( $description ) ) ;
        else
            $description = htmlspecialchars( $description );

        $o = Outlet::create([
            'outlet' => $outletname,
            'description' => $description,
            'contact_person' => $contact_person,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'viber' => $viber,
            'whatsapp' => $whatsapp,
            'skype' => $skype,
            'lat' => $lat,
            'lng' => $lng,
        ]);
        $result = Helper::createApiResponse($o);
        return $response->withJson($result);
    }



    public function putOutlet($request, $response) {

        $data = $request->getParsedBody();
        $outlet = $data['outlet'];
        $id = filter_var($outlet['id'], FILTER_SANITIZE_NUMBER_INT);
        $outletname = filter_var($outlet['outlet'], FILTER_SANITIZE_STRING);
        $description = $outlet['description'];
        $contact_person = filter_var($outlet['contact_person'], FILTER_SANITIZE_STRING);
        $address = filter_var($outlet['address'], FILTER_SANITIZE_STRING);
        $phone = filter_var($outlet['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($outlet['email'], FILTER_SANITIZE_STRING);
        $viber = filter_var($outlet['viber'], FILTER_SANITIZE_STRING);
        $whatsapp = filter_var($outlet['whatsapp'], FILTER_SANITIZE_STRING);
        $skype = filter_var($outlet['skype'], FILTER_SANITIZE_STRING);
        $lat = filter_var($outlet['lat'], FILTER_SANITIZE_STRING);
        $lng = filter_var($outlet['lng'], FILTER_SANITIZE_STRING);
        if ( get_magic_quotes_gpc() )
            $description = htmlspecialchars( stripslashes( $description ) ) ;
        else
            $description = htmlspecialchars( $description );

        $o = Outlet::where('id', $id)->update([
            'outlet' => $outletname,
            'description' => $description,
            'contact_person' => $contact_person,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'viber' => $viber,
            'whatsapp' => $whatsapp,
            'skype' => $skype,
            'lat' => $lat,
            'lng' => $lng,
        ]);
        $result = Helper::createApiResponse($o);
        return $response->withJson($result);
    }

    public function deleteOutlet($request, $response, $args) {
        $id = $args['id'];

        $pm = Outlet::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }


} 