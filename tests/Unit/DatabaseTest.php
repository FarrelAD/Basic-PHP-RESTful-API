<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseConfigurationDefaults(): void
    {
        $_ENV['DB_HOST'] = '127.0.0.1';
        $_ENV['DB_USER'] = 'testuser';
        $_ENV['DB_PASS'] = 'secret';
        $_ENV['DB_NAME'] = 'test_db';
        $_ENV['DB_PORT'] = '3307';

        $db = new Database();

        $this->assertEquals('127.0.0.1', $db->getHost());
        $this->assertEquals('testuser', $db->getUser());
        $this->assertEquals('test_db', $db->getDbName());
        $this->assertEquals('3307', $db->getPort());
    }
}
