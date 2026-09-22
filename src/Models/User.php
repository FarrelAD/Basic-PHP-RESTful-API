<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use App\Utils\Logger;
use Exception;
use PDO;
use PDOException;

class User
{
    private ?PDO $conn;

    public function __construct(?PDO $conn = null)
    {
        if ($conn !== null) {
            $this->conn = $conn;
        } else {
            try {
                $this->conn = (new Database())->connect();
            } catch (Exception $e) {
                $this->conn = null;
                Logger::error("Connection failed: " . $e->getMessage());
            }
        }
    }

    public function getAllUsers(): ?array
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "SELECT * FROM user";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return null;
        }
    }

    public function getUserById(int $id): ?array
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "SELECT * FROM user WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result !== false ? $result : null;
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return null;
        }
    }

    public function getUserByName(string $name): ?array
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "SELECT * FROM user WHERE name = :name";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result !== false ? $result : null;
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return null;
        }
    }

    public function createUser(string $name, int $age, string $job): bool
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "INSERT INTO user (name, age, job) VALUES (:name, :age, :job)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':job', $job, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserName(int $id, string $newName): bool
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "UPDATE user SET name = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $newName, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserAge(int $id, int $newAge): bool
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "UPDATE user SET age = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $newAge, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserJob(int $id, string $newJob): bool
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "UPDATE user SET job = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $newJob, PDO::PARAM_STR);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUserById(int $userId): bool
    {
        try {
            if ($this->conn === null) {
                throw new Exception("Database connection is null.");
            }

            $query = "DELETE FROM user WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException | Exception $e) {
            Logger::error("Query failed: " . $e->getMessage());
            return false;
        }
    }
}
