<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    private function jsonResponse(mixed $data, string $message, int $status): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    private function messageResponse(string $message, int $status): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }

    protected function success(mixed $data, string $message): JsonResponse
    {
        return $this->jsonResponse($data, $message, Response::HTTP_OK);
    }

    protected function created(mixed $data, string $message): JsonResponse
    {
        return $this->jsonResponse($data, $message, Response::HTTP_CREATED);
    }

    protected function error(string $message, int $status): JsonResponse
    {
        return $this->messageResponse($message, $status);
    }

    protected function ok(string $message): JsonResponse
    {
        return $this->messageResponse($message, Response::HTTP_OK);
    }
}
