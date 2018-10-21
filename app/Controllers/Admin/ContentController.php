<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Content;
use App\Controllers\Admin\Helper;


class ContentController extends Controller {


    public function getContent($request, $response) {
        
        $contents = Content::orderBy('content_type')->orderBy('title')->get();
        $result = Helper::createApiResponse($contents);
        return $response->withJson($result);
        
    }


    public function postContent($request, $response) {

        $data = $request->getParsedBody();
        $content = $data['content'];
        $title = filter_var($content['title'], FILTER_SANITIZE_STRING);
        $slug = filter_var($content['slug'], FILTER_SANITIZE_STRING);
        $content_type = filter_var($content['content_type'], FILTER_SANITIZE_STRING);
        $contentbody = $content['content'];
        if ( get_magic_quotes_gpc() )
            $contentbody = htmlspecialchars( stripslashes( $contentbody ) ) ;
        else
            $contentbody = htmlspecialchars( $contentbody ) ;

        $con = Content::create([
            'title' => $title,
            'slug' => $slug,
            'content' => $contentbody,
            'content_type' => $content_type
        ]);
        $result = Helper::createApiResponse($con);
        return $response->withJson($result);
    }



    public function putContent($request, $response) {

        $data = $request->getParsedBody();
        $content = $data['content'];
        $id = filter_var($content['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($content['title'], FILTER_SANITIZE_STRING);
        $slug = filter_var($content['slug'], FILTER_SANITIZE_STRING);
        $content_type = filter_var($content['content_type'], FILTER_SANITIZE_STRING);
        $contentbody = $content['content'];
        if ( get_magic_quotes_gpc() )
            $contentbody = htmlspecialchars( stripslashes( $contentbody ) ) ;
        else
            $contentbody = htmlspecialchars( $contentbody ) ;
        $this->logger->addInfo($contentbody);
        $con = Content::where('id', $id)->update([
            'title' => $title,
            'slug' => $slug,
            'content' => $contentbody,
            'content_type' => $content_type
        ]);
        $result = Helper::createApiResponse($con);

        return $response->withJson($result);
    }

    public function deleteContent($request, $response, $args) {
        $id = $args['id'];

        $pm = Content::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }


} 