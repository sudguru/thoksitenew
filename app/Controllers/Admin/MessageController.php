<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Message;
use App\Controllers\Admin\Helper;

class MessageController extends Controller {


    public function getMessage($request, $response) {

        // $this->logger->addInfo($request);

        $messages = Message::all();
        $result = Helper::createApiResponse($messages);
        return $response->withJson($result);
        
    }

    public function postMessage($request, $response) {

        $data = $request->getParsedBody();
        $message = $data['message'];
        $title = filter_var($message['title'], FILTER_SANITIZE_STRING);
        $display_order = filter_var($message['display_order'], FILTER_SANITIZE_NUMBER_INT);
        $link = filter_var($message['link'], FILTER_SANITIZE_STRING);

        $i = Message::create([
            'title' => $title,
            'display_order' => $display_order,
            'link' => $link
        ]);
        $result = Helper::createApiResponse($i);
        return $response->withJson($result);
    }

    public function putMessage($request, $response) {

        $data = $request->getParsedBody();
        $message = $data['message'];
        
        $id = filter_var($message['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($message['title'], FILTER_SANITIZE_STRING);
        $display_order = filter_var($message['display_order'], FILTER_SANITIZE_NUMBER_INT);
        $link = filter_var($message['link'], FILTER_SANITIZE_STRING);

        $pm = Message::where('id', $id)->update([
            'title' => $title,
            'display_order' => $display_order,
            'link' => $link
        ]);
        $result = Helper::createApiResponse($pm);
        
        return $response->withJson($result);
    }

    public function deleteMessage($request, $response, $args) {
        $id = $args['id'];

        $pm = Message::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }
} 