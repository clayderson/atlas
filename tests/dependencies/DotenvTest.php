<?php

declare(strict_types=1);

namespace Atlas\Tests\Dependencies;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

final class DotenvTest extends TestCase
{
    private $dotenv;

    public function assertPreConditions(): void
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $this->dotenv->load();
    }

    public function testDotenvInstanceWasCreated(): void
    {
        $this->assertTrue($this->dotenv instanceof Dotenv);
    }
}
