<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait SendApiResponse
{
   
    public function sendResponse(string $message, $result = [], int $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];
        return response()->json($response, $statusCode);
    }
    /**
     * Error response method.
     *
     * @param mixed $errorMessages
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError(string $error, $errorMessages = [], int $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

}
