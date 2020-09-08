<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

final class DotenvTest extends TestCase
{
    private $dotenv;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__);
        $this->dotenv->load();

        parent::__construct($name, $data, $dataName);
    }

    public function testIfEnvironmentFileIsLoaded(): void
    {
        $this->assertIsString($_ENV['STRING_VALUE']);
    }
}
