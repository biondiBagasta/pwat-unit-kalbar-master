<?php

namespace App\Helpers;

class ApiResponse {
    public static function successResponse(
        string $message
    ) {
        return response()->json([
            "success" => true,
            "message" => $message
        ]);
    }

    public static function errorResponse(
        string $message
    ) {
        return response()->json([
            "success" => false,
            "message" => $message
        ]);
    }
}
