<?php

namespace App\Controllers;

use App\Models\Setting;
use App\Models\Banner;
use App\Models\Infobox;
use App\Models\Message;

class HomeController extends Controller {
    

    public function index($request, $response) {
        $setting = Setting::first();
        $main_banners = Banner::where('position', 'Home Main')->orderBy('display_order')->get();
        $sub_banners = Banner::where('position', 'Home Sub Main')->orderBy('display_order')->limit(3)->get();
        $infoboxes = Infobox::orderBy('display_order')->limit(3)->get();
        $messages = Message::orderBy('display_order')->limit(10)->get();
        return $this->view->render($response, 'index.html', [
                'setting' => $setting,
                'main_banners' => $main_banners,
                'infoboxes' => $infoboxes,
                'messages' => $messages,
                'sub_banners' => $sub_banners
            ]
        );
    }
}