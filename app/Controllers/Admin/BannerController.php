<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\Banner;
use App\Controllers\Admin\Helper;


class BannerController extends Controller {


    public function getBanner($request, $response) {
        
        $banners = Banner::orderBy('display_order')->get();
        $result = Helper::createApiResponse($banners);
        return $response->withJson($result);
        
    }


    public function postUploadImageAndAddRecord($request, $response) {
        $upload_dir = "../public/uploads/banners/";
        $data = $request->getParsedBody();
        $photo = $data['myFile'];
        $filename = $data['filename'];
        $position = $data['position'];
        $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $subtitle = filter_var($data['subtitle'], FILTER_SANITIZE_STRING);
        $link = filter_var($data['link'], FILTER_SANITIZE_STRING);
        $textat = filter_var($banner['textat'], FILTER_SANITIZE_STRING);

        $secret = $data['secret'];
        if ($secret != 'SudeepsSecret') {
            return $response->withJson('Upload Denied');
        }
        
        $img = str_replace('data:image/png;base64,', '', $photo);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imagedata = base64_decode($img);
        $file = $upload_dir . $filename;
        $success = file_put_contents($file, $imagedata);
        $display_order = $this->getRowCountByPostion($position) + 1;
        $b = Banner::create([
            'display_order' => $display_order,
            'position' => $position,
            'banner' => $filename,
            'title' => $title,
            'subtitle' => $subtitle,
            'link' => $link,
            'textat' => $textat
        ]);
        $result = Helper::createApiResponse($b);
        return $response->withJson($result);
    }



    public function putBanner($request, $response) {

        $data = $request->getParsedBody();
        $banner = $data['banner'];
        $id = filter_var($banner['id'], FILTER_SANITIZE_NUMBER_INT);
        $position = filter_var($banner['position'], FILTER_SANITIZE_STRING);
        $title = filter_var($banner['title'], FILTER_SANITIZE_STRING);
        $subtitle = filter_var($banner['subtitle'], FILTER_SANITIZE_STRING);
        $link = filter_var($banner['link'], FILTER_SANITIZE_STRING);
        $textat = filter_var($banner['textat'], FILTER_SANITIZE_STRING);

        $display_order = $this->getRowCountByPostion($position) + 1;
        if($old_position != $position) {
            $b = Banner::where('id', $id)->update([
                'position' => $position,
                'display_order' => $display_order,
                'title' => $title,
                'subtitle' => $subtitle,
                'link' => $link,
                'textat' => $textat
            ]);
        } else {
            $b = Banner::where('id', $id)->update([
                'title' => $title,
                'subtitle' => $subtitle,
                'link' => $link,
                'textat' => $textat
            ]);
        }
        $result = Helper::createApiResponse($b);
        return $response->withJson($result);
    }

    public function deleteBanner($request, $response, $args) {
        $id = $args['id'];
        $banner = $this->getBannerName($id);
        unlink("../public/uploads/banners/" . $banner);
        $position = $this->getOldPostion($id);
        $pm = Banner::destroy($id);
        $remaining_banners = $this->getBannersInCurrentPosition($position);
        $this->reorder($remaining_banners);
        $result = Helper::createApiResponse($pm);
        return $response->withJson($result);
    }

    public function prepareAndReorder($request, $response) {
        $data = $request->getParsedBody();
        $banners = $data['banners'];
        $reorder = $this->reorder($banners);
        $this->logger->addInfo('reorder' . $reorder);
        $result = Helper::createApiResponse($reorder, 'ok');
        return $response->withJson($result);
    }

    private function getOldPostion($id) {

        $b = Banner::where('id', $id)->first();
        return $b->position;
    }

    private function getRowCountByPostion($position) {
        return Banner::where('position', $position)->count();
    }

    private function getBannerName($id) {
        $b = Banner::where('id', $id)->first();
        return $b->banner;
    }
    

    private function reorder($newBannersArray) {
        //this never fails ?
        $i = 0;
        foreach ($newBannersArray as $banner) {
            $i++;
            Banner::where('id', $banner['id'])->update(['display_order' => $i]);
        }
        return true;
    }
    
    private function getBannersInCurrentPosition($position) {
        return Banner::where('position', $position)->get();
    }

} 