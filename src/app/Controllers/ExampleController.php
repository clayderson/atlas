<?php

declare(strict_types=1);

namespace Atlas\App\Controllers;

use Atlas\Core\Request;
use Atlas\Core\Response;

final class ExampleController
{
    public function index(Request $request, Response $response, array $params)
    {
        return [
            'author' => [
                'name' => 'Clayderson Ferreira',
                'email' => 'clayderson2010@gmail.com',
            ],
        ];
    }
}
