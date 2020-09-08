<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

use Atlas\Core\Request;
use Atlas\Core\Response;
use Atlas\Core\ErrorHandler;
use Atlas\Core\Route;

$request = new Request();
$response = new Response();

ErrorHandler::initialize($request, $response);
Route::initialize($request, $response);
