<?php

namespace App\Controllers\Admin;

class Helper {

    public static function createApiResponse($data, $returndata = null) {
        if ($data) {
            $result = [
                'status' => 200,
                'error' => null,
                'data' => $returndata ? $returndata:  $data
            ];
        } else {
            $result = [
                'status' => 500,
                'error' => "Error Occured !",
                'data' => null
            ];
        }
        return $result;
    }

}