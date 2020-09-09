<?php

declare(strict_types=1);

namespace Atlas\Tests\Core;

use PHPUnit\Framework\TestCase;
use Atlas\Tests\PHPUnitUtils;
use Atlas\Core\ErrorHandler;

final class ErrorHandlerTest extends TestCase
{
    public function testNormalizeStatusCodeWithValidHttpCode(): void
    {
        $this->assertEquals(404, PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeStatusCode', [
            404,
        ]));
    }

    public function testNormalizeStatusCodeWithInvalidHttpCode(): void
    {
        $this->assertEquals(500, PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeStatusCode', [
            999,
        ]));
    }

    public function testNormalizeErrorMessage(): void
    {
        $this->assertIsString(PHPUnitUtils::getPrivateMethod(ErrorHandler::class, 'normalizeMessage', [
            500, 'Any error message'
        ]));
    }
}
