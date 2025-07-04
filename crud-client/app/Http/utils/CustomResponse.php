<?php

namespace App\Http\utils;

use Symfony\Component\HttpFoundation\Response;

class CustomResponse
{
    public static function success($data = [], string $message = 'Operación exitosa', int $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function error($data = [], string $message = 'Ocurrió un error', int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $data,
        ], $statusCode);
    }

}
