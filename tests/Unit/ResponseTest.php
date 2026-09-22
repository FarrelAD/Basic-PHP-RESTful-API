<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Utils\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testJsonOutputsValidJsonAndStatus(): void
    {
        // Capture output
        ob_start();
        Response::json(200, [
            'status' => 'success',
            'message' => 'Hello World'
        ]);
        $output = ob_get_clean();

        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $decoded = json_decode($output, true);
        $this->assertEquals('success', $decoded['status']);
        $this->assertEquals('Hello World', $decoded['message']);
    }
}
