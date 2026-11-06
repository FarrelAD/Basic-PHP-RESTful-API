<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Request;
use App\Utils\Response;
use Exception;

class UsersController
{
    private User $user;

    public function __construct(?User $user = null)
    {
        $this->user = $user ?? new User();
    }

    public function getAllUsers(): void
    {
        try {
            $result = $this->user->getAllUsers();

            Response::json(200, [
                "status" => "success",
                "message" => "Successfully retrieved all users",
                "data" => $result ?? [],
            ]);
        } catch (Exception $e) {
            Response::json(500, [
                "status" => "error",
                "message" => "Internal server error",
            ]);
        }
    }

    public function getUserById(int $userId): void
    {
        try {
            $result = $this->user->getUserById($userId);

            if ($result === null) {
                Response::json(404, [
                    "status" => "error",
                    "message" => "User not found",
                ]);
                return;
            }

            Response::json(200, [
                "status" => "success",
                "message" => "Successfully retrieved user",
                "data" => $result,
            ]);
        } catch (Exception $e) {
            Response::json(500, [
                "status" => "error",
                "message" => "Internal server error",
            ]);
        }
    }

    public function createUser(): void
    {
        try {
            $input = Request::getJson();

            $name = isset($input['name']) && is_string($input['name']) ? trim($input['name']) : '';
            $age = isset($input['age']) && is_numeric($input['age']) ? (int)$input['age'] : null;
            $job = isset($input['job']) && is_string($input['job']) ? trim($input['job']) : '';

            if ($name === '' || $age === null || $job === '') {
                Response::json(422, [
                    "status" => "error",
                    "message" => "Unprocessable Entity: 'name' (string), " .
                                 "'age' (int), and 'job' (string) are required in JSON body",
                ]);
                return;
            }

            $success = $this->user->createUser($name, $age, $job);
            if (!$success) {
                Response::json(400, [
                    "status" => "error",
                    "message" => "Failed to create user",
                ]);
                return;
            }

            $createdUser = $this->user->getUserByName($name);

            Response::json(201, [
                "status" => "success",
                "message" => "Successfully created user",
                "data" => $createdUser,
            ]);
        } catch (Exception $e) {
            Response::json(500, [
                "status" => "error",
                "message" => "Internal server error",
            ]);
        }
    }

    public function updateUser(int $userId): void
    {
        try {
            $existingUser = $this->user->getUserById($userId);

            if ($existingUser === null) {
                Response::json(404, [
                    "status" => "error",
                    "message" => "User not found",
                ]);
                return;
            }

            $inputData = Request::getJson();

            if (empty($inputData)) {
                Response::json(400, [
                    "status" => "error",
                    "message" => "Request body cannot be empty",
                ]);
                return;
            }

            if (!isset($inputData['name']) && !isset($inputData['age']) && !isset($inputData['job'])) {
                Response::json(422, [
                    "status" => "error",
                    "message" => "Provide at least one field to update ('name', 'age', or 'job')",
                ]);
                return;
            }

            if (isset($inputData["name"])) {
                $this->user->updateUserName($userId, trim((string)$inputData["name"]));
            }

            if (isset($inputData["age"])) {
                $this->user->updateUserAge($userId, (int)$inputData["age"]);
            }

            if (isset($inputData["job"])) {
                $this->user->updateUserJob($userId, trim((string)$inputData["job"]));
            }

            $updatedUser = $this->user->getUserById($userId);

            Response::json(200, [
                "status" => "success",
                "message" => "Successfully updated user",
                "data" => $updatedUser,
            ]);
        } catch (Exception $e) {
            Response::json(500, [
                "status" => "error",
                "message" => "Internal server error",
            ]);
        }
    }

    public function deleteUser(int $userId): void
    {
        try {
            $existingUser = $this->user->getUserById($userId);

            if ($existingUser === null) {
                Response::json(404, [
                    "status" => "error",
                    "message" => "User not found",
                ]);
                return;
            }

            $this->user->deleteUserById($userId);

            Response::json(200, [
                "status" => "success",
                "message" => "Successfully deleted user",
            ]);
        } catch (Exception $e) {
            Response::json(500, [
                "status" => "error",
                "message" => "Internal server error",
            ]);
        }
    }
}
