<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;

class RestController extends Controller
{
    public function success($data, $message = null, $code = 200)
    {
        if ($data instanceof JsonResource) {
            return $data->additional([
                'type' => 'success',
                'message' => $message,
            ]);
        }

        return response()->json([
            'type' => 'success',
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public function error($message = null, $code = 500, $data = null)
    {
        return response()->json([
            'type' => 'error',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
