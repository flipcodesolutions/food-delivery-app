<?php

if (!function_exists('apiResponse')) {
    function apiResponse($status = true, $message = '', $data = [], $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}