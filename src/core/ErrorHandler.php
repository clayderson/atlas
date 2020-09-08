<?php

declare(strict_types=1);

namespace Atlas\Core;

use Exception;

final class ErrorHandler
{
    private static $messages = [
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        408 => 'Request Timeout',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
    ];

    public static function initialize(Request $request, Response $response)
    {
        set_exception_handler(function (Exception $exception) use ($response) {
            $statusCode = self::normalizeStatusCode(
                $exception->getCode()
            );

            $response->status($statusCode)->json([
                'code' => $statusCode,
                'message' => self::normalizeMessage($statusCode, $exception->getMessage()),
                'data' => null,
            ]);
        });
    }

    private static function normalizeStatusCode(int $statusCode): int
    {
        return $statusCode >= 400 && $statusCode <= 599 ? $statusCode : 500;
    }

    private static function normalizeMessage(int $statusCode, string $originalMessage): string
    {
        if ($statusCode >= 500 && Env::get('DEBUG', false)) {
            return $originalMessage;
        }

        return self::$messages[$statusCode] ?? 'No Message';
    }
}
