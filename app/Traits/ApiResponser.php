<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    public function successResponse($data = [], $message = null, $code = Response::HTTP_OK)
    {
        $out = [
            'ok' => true,
            'data' => $data,
            'message' => $message,
        ];
        return \response()->json(array_filter($out), $code);
    }

    public function errorResponse($message, $code=Response::HTTP_NOT_FOUND, $data = [])
    {
        $out = [
            'ok' => false,
            'message' => $message,
        ] + (!empty($data) ? ['data' => $data] : []);
        return \response()->json($out, $code);
    }
}
