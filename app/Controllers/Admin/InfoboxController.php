<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Infobox;
use App\Controllers\Admin\Helper;

class InfoboxController extends Controller {


    public function getInfobox($request, $response) {

        // $this->logger->addInfo($request);

        $infoboxes = Infobox::all();
        $result = Helper::createApiResponse($infoboxes);
        return $response->withJson($result);
        
    }

    public function postInfobox($request, $response) {

        $data = $request->getParsedBody();
        $infobox = $data['infobox'];
        $title = filter_var($infobox['title'], FILTER_SANITIZE_STRING);
        $subtitle = filter_var($infobox['subtitle'], FILTER_SANITIZE_STRING);
        $display_order = filter_var($infobox['display_order'], FILTER_SANITIZE_NUMBER_INT);
        $icon = filter_var($infobox['icon'], FILTER_SANITIZE_STRING);
        $link = filter_var($infobox['link'], FILTER_SANITIZE_STRING);

        $i = Infobox::create([
            'title' => $title,
            'subtitle' => $subtitle,
            'display_order' => $display_order,
            'icon' => $icon,
            'link' => $link
        ]);
        $result = Helper::createApiResponse($i);
        return $response->withJson($result);
    }

    public function putInfobox($request, $response) {

        $data = $request->getParsedBody();
        $infobox = $data['infobox'];
        
        $id = filter_var($infobox['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($infobox['title'], FILTER_SANITIZE_STRING);
        $subtitle = filter_var($infobox['subtitle'], FILTER_SANITIZE_STRING);
        $display_order = filter_var($infobox['display_order'], FILTER_SANITIZE_NUMBER_INT);
        $icon = filter_var($infobox['icon'], FILTER_SANITIZE_STRING);
        $link = filter_var($infobox['link'], FILTER_SANITIZE_STRING);

        $pm = Infobox::where('id', $id)->update([
            'title' => $title,
            'subtitle' => $subtitle,
            'display_order' => $display_order,
            'icon' => $icon,
            'link' => $link
        ]);
        $result = Helper::createApiResponse($pm);
        
        return $response->withJson($result);
    }

    public function deleteInfobox($request, $response, $args) {
        $id = $args['id'];

        $pm = Infobox::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }
} 