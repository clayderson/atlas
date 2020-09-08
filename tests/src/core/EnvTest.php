<?php

declare(strict_types=1);

namespace Atlas\Tests\Core;

use PHPUnit\Framework\TestCase;
use Atlas\Tests\PHPUnitUtils;
use Atlas\Core\Env;

final class EnvTest extends TestCase
{
    public function testIsLoadedBeforeLoad(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'isLoaded');
        $this->assertEquals(false, $result);
    }

    public function testIsLoadedAfterLoad(): void
    {
        PHPUnitUtils::getPrivateMethod(Env::class, 'load');
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'isLoaded');
        $this->assertEquals(true, $result);
    }

    public function testGetWithNotRecognizedEnvironmentVariable(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'get', [
            str_shuffle('ABCDEF'), 'Cupcake'
        ]);

        $this->assertEquals('Cupcake', $result);
    }

    public function testGetWithDebugEnvironmentVariable(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'get', [
            'DEBUG'
        ]);

        $this->assertIsBool($result);
    }

    public function testParseBooleanWithParsableString(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            'false',
        ]);

        $this->assertEquals(false, $result);
    }

    public function testParseBooleanWithUnparseableString(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            'Atlas',
        ]);

        $this->assertEquals('Atlas', $result);
    }

    public function testParseBooleanWithEmptyString(): void
    {
        $result = PHPUnitUtils::getPrivateMethod(Env::class, 'parseBoolean', [
            '',
        ]);

        $this->assertEquals('', $result);
    }
}
