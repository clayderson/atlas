<?php

declare(strict_types=1);

namespace Atlas\Tests\Core;

use PHPUnit\Framework\TestCase;
use Atlas\Tests\PHPUnitUtils;
use Atlas\Core\ErrorHandler;

final class ErrorHandlerTest extends TestCase
{
    public function testNormalizeStatusCodeWithValidCode(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeStatusCode', [
            404,
        ]);

        $this->assertEquals(404, $result);
    }

    public function testNormalizeStatusCodeWithInvalidCode(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeStatusCode', [
            600,
        ]);

        $this->assertEquals(500, $result);
    }

    public function testNormalizeMessage(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeMessage', [
            500, 'Any error message'
        ]);

        $this->assertIsString($result);
    }
}
