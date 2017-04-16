<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class BaseController extends Controller
{
    protected function responseSuccess($message = null, $data = null, $status = 200)
    {
        return \Response::json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function responseError($message = null, $errors = null, $status = 500)
    {
        return \Response::json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'data' => $errors
        ]);
    }
}