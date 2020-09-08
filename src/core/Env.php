<?php

declare(strict_types=1);

namespace Atlas\Core;

use Dotenv\Dotenv;

final class Env
{
    private static $dotenv;

    public static function get(string $key, $default = null)
    {
        if (self::isLoaded() === false) {
            self::load();
        }

        return self::parseBoolean($_ENV[$key] ?? $default);
    }

    private static function isLoaded(): bool
    {
        return self::$dotenv instanceof Dotenv;
    }

    private static function load(): void
    {
        self::$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        self::$dotenv->load();
    }

    private static function parseBoolean($str)
    {
        switch ($str) {
            case 'true':
                return true;
            case 'false':
                return false;
            default:
                return $str;
        }
    }
}
