<?php

use Tlab\Boot;
use Tlab\JsonValidator;
use Symfony\Component\HttpFoundation\Response;

require('../bootstrap.php');

$boot = Boot::getInstance();
$request = $boot->getRequest();
try {
    $jsonValidator = new JsonValidator();
    $result = $jsonValidator->validate($request);
    $response = new Response(
        $result,
        Response::HTTP_OK,
        ['Content-Type' => 'application/json']
    );
} catch (Exception $e) {
    $response = new Response(
        json_encode([
            'valid' => false,
            'message' => 'Invalid data',
        ]),
        Response::HTTP_BAD_REQUEST,
        ['Content-Type' => 'application/json']
    );
}

$response->send();
