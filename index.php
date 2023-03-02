<?php
require_once __DIR__.'/vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $n = $request->getQueryParams()['n'] ?? null;
    if (!is_numeric($n)) {
        $response->getBody()->write(json_encode(['error' => 'Parameter n harus berupa angka']));
        return $response->withStatus(400);
    }
    $n = intval($n);
    try {
        $result = fibonacci($n);
        $response->getBody()->write(json_encode(['result' => $result]));
        return $response->withStatus(200);
    } catch (InvalidArgumentException $e) {
        $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        return $response->withStatus(400);
    }
});

$app->run();