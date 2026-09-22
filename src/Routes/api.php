<?php

declare(strict_types=1);

use App\Controllers\UsersController;
use App\Utils\Response;

$usersController = new UsersController();

$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($requestUri === "/" || $requestUri === "") {
    switch ($requestMethod) {
        case "GET":
            Response::json(200, [
                "status" => "success",
                "message" => "Welcome to Basic PHP RESTful API"
            ]);
            break;
        default:
            Response::json(405, [
                "status" => "error",
                "message" => "Method Not Allowed"
            ]);
            break;
    }
} elseif ($requestUri === "/api/users") {
    switch ($requestMethod) {
        case "GET":
            $usersController->getAllUsers();
            break;
        case "POST":
            $usersController->createUser();
            break;
        default:
            Response::json(405, [
                "status" => "error",
                "message" => "Method Not Allowed"
            ]);
            break;
    }
} elseif (preg_match('#^/api/users/(\d+)$#', $requestUri, $matches)) {
    $userId = (int)$matches[1];
    switch ($requestMethod) {
        case "GET":
            $usersController->getUserById($userId);
            break;
        case "PATCH":
            $usersController->updateUser($userId);
            break;
        case "DELETE":
            $usersController->deleteUser($userId);
            break;
        default:
            Response::json(405, [
                "status" => "error",
                "message" => "Method Not Allowed"
            ]);
            break;
    }
} else {
    Response::json(404, [
        "status" => "error",
        "message" => "Error 404! No route found!"
    ]);
}