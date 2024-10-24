<?php

require_once __DIR__ . '/../controllers/UsersController.php';

$usersController = new UsersController();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri == "/" && $requestMethod == "GET") {
    echo "You are in the root page!";
} elseif ($requestUri == "/users" && $requestMethod == "GET") {
    $usersController->getAllUser();
} elseif (preg_match('#^/users/(\d+)$#', $requestUri, $matches) && $requestMethod == "GET") {
    $userId = $matches[1];
    $usersController->getUserById($userId);
} else {
    http_response_code(404);
    echo "Error 404! No route found!";
}
