<?php

if (! function_exists('customResponse')) {
    function customResponse($status = 200, $message = 'success', $data = '', $iv = '', $headers = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'iv' => $iv,
        ], $status, $headers);
    }
}