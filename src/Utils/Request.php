<?php

declare(strict_types=1);

namespace App\Utils;

class Request
{
    public static function getJson(?string $rawInput = null): array
    {
        $raw = $rawInput ?? file_get_contents('php://input');
        if (empty($raw)) {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
