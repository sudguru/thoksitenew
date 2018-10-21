<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Category;
use App\Controllers\Admin\Helper;


class CategoryController extends Controller {


    public function getCategory($request, $response) {
        
        $categories = Category::orderBy('category')->get();
        $result = Helper::createApiResponse($categories);
        return $response->withJson($result);
        
        
    }



    public function getRootCategory($request, $response) {

        $categories = Category::where('parent_id', 0)->orderBy('category')->get();
        $result = Helper::createApiResponse($categories);
        return $response->withJson($result);
    }



    public function postCategory($request, $response) {

        $data = $request->getParsedBody();
        $c = $data['category'];
        $category = filter_var($c['category'], FILTER_SANITIZE_STRING);
        $description = filter_var($c['description'], FILTER_SANITIZE_STRING);
        $parent_id = filter_var($c['parent_id'], FILTER_SANITIZE_STRING);

        $cat = Category::create([
            'category' => $category,
            'description' => $description,
            'parent_id' => $parent_id
        ]);
        $result = Helper::createApiResponse($cat);
        return $response->withJson($result);
    }



    public function putCategory($request, $response) {

        $data = $request->getParsedBody();
        $c = $data['category'];
        $id = filter_var($c['id'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($c['category'], FILTER_SANITIZE_STRING);
        $description = filter_var($c['description'], FILTER_SANITIZE_STRING);
        $parent_id = filter_var($c['parent_id'], FILTER_SANITIZE_NUMBER_INT);

        $cat = Category::where('id', $id)->update([
            'category' => $category,
            'description' => $description,
            'parent_id' => $parent_id,
        ]);
        $result = Helper::createApiResponse($cat);

        return $response->withJson($result);
    }

    public function deleteCategory($request, $response, $args) {
        $id = $args['id'];
        $banner = $this->getBannerName($id);
        unlink("../public/uploads/categorybanners/" . $banner);
        $pm = Category::destroy($id);
        $result = Helper::createApiResponse($pm);

        return $response->withJson($result);
    }


    public function postCategoryPhoto($request, $response) {

        $upload_dir = "../public/uploads/categorybanners/";
        $data = $request->getParsedBody();
        $photo = $data['myFile'];
        $filename = $data['filename'];
        $id = $data['id'];
        // $this->logger->addInfo('id is ' . $id);

        $secret = $data['secret'];
        if ($secret != 'SudeepsSecret') {
            return $response->withJson('Upload Denied');
        }
        // $this->logger->addInfo(print_r($photo,true));

        $img = str_replace('data:image/png;base64,', '', $photo);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imagedata = base64_decode($img);
        $file = $upload_dir . $filename;
        $success = file_put_contents($file, $imagedata);

        $cat = Category::where('id', $id)->update([
            'banner' => $filename
        ]);
        $result = Helper::createApiResponse($cat, $filename);
        return $response->withJson($result);
    }
    
    private function getBannerName($id) {
        $b = Category::where('id', $id)->first();
        return $b->banner;
    }
} 