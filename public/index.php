<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenvPath = dirname(__DIR__);
if (file_exists($dotenvPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($dotenvPath);
    $dotenv->safeLoad();
}

require_once __DIR__ . '/../src/Routes/api.php';
