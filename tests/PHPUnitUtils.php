<?php

declare(strict_types=1);

namespace Atlas\Tests;

use ReflectionClass;

final class PHPUnitUtils
{
    public static function getPrivateMethod($obj, $name, array $args = [])
    {
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs(new $obj, $args);
    }
}
