<?php

declare(strict_types=1);

namespace Atlas\Core;

use Exception;

final class Response
{
    private $code;
    private $headers;

    public function __construct()
    {
        $this->code = 200;
        $this->headers = [];
    }

    public function status(int $code): Response
    {
        if ($code < 100 || $code > 599) {
            throw new Exception('Invalid HTTP status code');
        }

        $this->code = $code;
        return $this;
    }

    public function header(string $name, string $value): Response
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json($body): void
    {
        $this->header('Content-Type', 'application/json');
        $this->send(json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function send($body): void
    {
        $this->dispatchHeaders();
        echo $body;
    }

    private function dispatchHeaders(): void
    {
        http_response_code($this->code);

        foreach ($this->headers as $headerName => $headerValue) {
            header("{$headerName}: {$headerValue}");
        }
    }
}
