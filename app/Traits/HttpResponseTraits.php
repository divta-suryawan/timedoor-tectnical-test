<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HttpResponseTraits
{
    //Return a successful JSON response with optional payload data
    protected function success(mixed $payload = null, string $message = '', int $code = 200)
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $payload
        ];

        return response()->json($data);
    }

    // Return a JSON response when requested data is not found
    protected function dataNotFound($message = '', int $code = 404)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }

    // Return a JSON response when an ID or data record is not found
    protected function idOrDataNotFound($message = 'ID or data not found', int $code = 404)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }

    // Return a JSON response when data deletion is successful
    protected function delete($message = '', int $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }

    // Return an error JSON response and log the exception details
    protected function error(string $message = '', int $code = 400, mixed $payload = null, mixed $class = null, string $method = '')
    {
        $data = [
            'code' => $code,
            'message' => $message
        ];

        if ($payload) {
            Log::error($class, [
                'Message: ' . $payload->getMessage(),
                'Method: '  . $method,
                'On File: ' . $payload->getFile(),
                'On Line: ' . $payload->getLine()
            ]);

            if (config('app.debug')) {
                $data['error'] = [
                    'exception_message' => $payload->getMessage(),
                    'file' => $payload->getFile(),
                    'line' => $payload->getLine(),
                    'method' => $method,
                    'class' => $class
                ];
            }
        }

        return response()->json($data, $code);
    }
}
