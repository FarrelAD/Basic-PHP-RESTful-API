<?php

declare(strict_types=1);

namespace App\Utils;

class Response
{
    public static function json(int $statusCode, array $payload): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
    }
}
