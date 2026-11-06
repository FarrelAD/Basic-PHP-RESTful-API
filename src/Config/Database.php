<?php

declare(strict_types=1);

namespace App\Config;

use App\Utils\Logger;
use PDO;
use PDOException;

class Database
{
    private string $dbHost;
    private string $dbUser;
    private string $dbPass;
    private string $dbName;
    private string $dbPort;
    private ?PDO $conn = null;

    public function __construct()
    {
        $this->dbHost = $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbUser = $_ENV['DB_USER'] ?? 'root';
        $this->dbPass = $_ENV['DB_PASS'] ?? '';
        $this->dbName = $_ENV['DB_NAME'] ?? '';
        $this->dbPort = $_ENV['DB_PORT'] ?? '3306';
    }

    public function getHost(): string
    {
        return $this->dbHost;
    }

    public function getUser(): string
    {
        return $this->dbUser;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getPort(): string
    {
        return $this->dbPort;
    }

    public function connect(): ?PDO
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->dbHost};port={$this->dbPort};dbname={$this->dbName};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->dbUser, $this->dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            Logger::error("Connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }
}
