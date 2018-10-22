<?php

namespace App\Controllers\Account;

use App\Models\Setting;
use App\Models\Infobox;
use App\Models\Message;
use App\Controllers\Controller;

class DashboardController extends Controller {
    

    public function index($request, $response) {
        $setting = Setting::first();
        $infoboxes = Infobox::orderBy('display_order')->limit(3)->get();
        $messages = Message::orderBy('display_order')->limit(10)->get();
        return $this->view->render($response, 'account/dashboard.html', [
                'setting' => $setting,
                'infoboxes' => $infoboxes,
                'messages' => $messages,
                'currentPage' => 'dashboard'
            ]
        );
    }
}