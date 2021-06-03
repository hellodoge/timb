<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\handlers\Handler;
use repository\Postgres;
use service\Service;
use service\ServiceConfig;
use function app\initRoutes;

Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$repository = new Postgres($_ENV['DATABASE_DSN'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
$service_config = new ServiceConfig();
$service_config->user->secret_key = $_ENV['SECRET_KEY'];
$service = new Service($repository, $service_config);
$handlers = new Handler($service);
$router = initRoutes($handlers, $service);

$requestPath = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($requestPath, $method);