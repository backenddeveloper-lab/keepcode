<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function send($data, $http_code = 200, $status = 'ok', $code = 'success', $message = ''){
        return response()->json([
                'data' => $data,
                'status' => $status,
                'code' => $code,
                'message' => $message,
            ],
            $http_code
        );
    }
}
