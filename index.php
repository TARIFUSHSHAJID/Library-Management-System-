<?php
require_once __DIR__ . '/model/config.php';

$url = $_GET['url'] ?? 'home/index';
$urlParts = explode('/', rtrim($url, '/'));

$controllerName = $urlParts[0] ?? 'home';
$methodName = $urlParts[1] ?? 'index';
$param = $urlParts[2] ?? null;

$controllerFile = BASE_PATH . '/controller/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    $functionName = $controllerName . '_' . $methodName;

    if (function_exists($functionName)) {
        if ($param !== null) {
            $functionName($param);
        } else {
            $functionName();
        }
    } else {
        die("Function $functionName not found");
    }
} else {
    die("Controller $controllerName not found");
}

