<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Utils\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGetJsonParsesValidJsonString(): void
    {
        $json = '{"name":"John Doe","age":25,"job":"Engineer"}';
        $result = Request::getJson($json);

        $this->assertIsArray($result);
        $this->assertEquals('John Doe', $result['name']);
        $this->assertEquals(25, $result['age']);
        $this->assertEquals('Engineer', $result['job']);
    }

    public function testGetJsonReturnsEmptyArrayOnInvalidJson(): void
    {
        $invalidJson = '{"name": "broken';
        $result = Request::getJson($invalidJson);

        $this->assertSame([], $result);
    }

    public function testGetJsonReturnsEmptyArrayOnNullOrEmpty(): void
    {
        $this->assertSame([], Request::getJson(''));
    }
}
