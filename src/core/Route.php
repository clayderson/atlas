<?php

declare(strict_types=1);

namespace Atlas\Core;

use \Exception;

final class Route
{
    private static $request;
    private static $response;
    private static $method;
    private static $uri;
    private static $routes;

    public static function initialize(Request $request, Response $response): void
    {
        self::$request = $request;
        self::$response = $response;
        self::$method = self::$request->method();
        self::$uri = self::normalizeURI(self::$request->path());
        self::execute();
    }

    public static function get(string $route, string $controller): void
    {
        self::addRoute('GET', $route, $controller);
    }

    public static function post(string $route, string $controller): void
    {
        self::addRoute('POST', $route, $controller);
    }

    public static function put(string $route, string $controller): void
    {
        self::addRoute('PUT', $route, $controller);
    }

    public static function patch(string $route, string $controller): void
    {
        self::addRoute('PATCH', $route, $controller);
    }

    public static function delete(string $route, string $controller): void
    {
        self::addRoute('DELETE', $route, $controller);
    }

    private static function addRoute(string $method, string $route, string $controller): void
    {
        if (empty(self::$routes)) {
            self::$routes = [];
        }

        self::$routes[$method][] = [
            'uri' => self::normalizeURI($route),
            'controller' => self::normalizeController($controller),
        ];
    }

    private static function normalizeURI(string $uri): array
    {
        return explode('/', ltrim($uri, '/'));
    }

    private static function normalizeController(string $controller): array
    {
        return explode(':', str_replace('/', '\\', "Atlas/App/Controllers/{$controller}"));
    }

    private static function execute(): void
    {
        $controller = null;
        $params = [];

        foreach (self::$routes[self::$method] as $route) {
            for ($i = 0; $i < count($route['uri']); $i += 1) {
                if (count($route['uri']) !== count(self::$uri)) {
                    break;
                }

                if (preg_match('/^:[a-zA-Z]+/', $route['uri'][$i]) && !empty(self::$uri[$i])) {
                    $params[ltrim($route['uri'][$i], ':')] = urldecode(self::$uri[$i]);
                } elseif ($route['uri'][$i] !== self::$uri[$i]) {
                    break;
                }

                if ($i === (count($route['uri']) - 1)) {
                    $controller = $route['controller'];
                    break 2;
                }
            }
        }

        if (!$controller) {
            throw new Exception('Could not combine any routes', 404);
        }

        [$class, $method] = $controller;

        if (!class_exists($class)) {
            throw new Exception("The class ${class} could not be found");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("The method {$method} was not found in the class {$class}");
        }

        $controllerResponse = (new $class)->$method(self::$request, self::$response, $params);

        if (isset($controllerResponse)) {
            self::$response->json($controllerResponse);
        }
    }
}
