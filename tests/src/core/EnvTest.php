<?php

declare(strict_types=1);

namespace Atlas\Tests\Core;

use PHPUnit\Framework\TestCase;
use Atlas\Tests\PHPUnitUtils;
use Atlas\Core\Env;

final class EnvTest extends TestCase
{
    public function testReturnsFalseIfIsLoadedWasCalledBeforeTheLoadMethod(): void
    {
        $this->assertEquals(false, PHPUnitUtils::getPrivateMethod(Env::class, 'isLoaded'));
    }

    public function testReturnsTrueIfIsLoadedWasCalledAfterTheLoadMethod(): void
    {
        PHPUnitUtils::getPrivateMethod(Env::class, 'load');
        $this->assertEquals(true, PHPUnitUtils::getPrivateMethod(Env::class, 'isLoaded'));
    }

    public function testGetWithNotRecognizedEnvironmentVariable(): void
    {
        $this->assertEquals('cupcake', PHPUnitUtils::getPrivateMethod(Env::class, 'get', [
            'UNDEFINED_ENV_VARIABLE', 'cupcake'
        ]));
    }

    public function testGetBooleanValueOfDebugEnvironmentVariable(): void
    {
        $this->assertIsBool(PHPUnitUtils::getPrivateMethod(Env::class, 'get', [
            'DEBUG'
        ]));
    }

    public function testParseBooleanWithParsableString(): void
    {
        $this->assertEquals(false, PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            'false',
        ]));
    }

    public function testParseBooleanWithUnparseableString(): void
    {
        $this->assertEquals('Atlas', PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            'Atlas',
        ]));
    }

    public function testParseBooleanWithEmptyString(): void
    {
        $this->assertEquals('', PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            '',
        ]));
    }
}
