<?php

declare(strict_types=1);

namespace Atlas\Core;

final class Request
{
    private $uri;
    private $method;
    private $get;
    private $post;
    private $cookie;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
    }

    public function path(): string
    {
        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function only(array $filter): array
    {
        $callback = function ($key) use ($filter) {
            return in_array($key, $filter);
        };

        return array_filter(
            $this->all(),
            $callback,
            ARRAY_FILTER_USE_KEY
        );
    }

    public function except(array $filter): array
    {
        $callback = function ($key) use ($filter) {
            return !in_array($key, $filter);
        };

        return array_filter(
            $this->all(),
            $callback,
            ARRAY_FILTER_USE_KEY
        );
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function query(string $key)
    {
        return $this->get[$key] ?? null;
    }

    public function input(string $key)
    {
        return $this->post[$key] ?? null;
    }

    public function cookie(string $key)
    {
        return $this->cookie[$key] ?? null;
    }
}
