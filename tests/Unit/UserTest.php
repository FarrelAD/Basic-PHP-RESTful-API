<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use PDO;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private PDO $pdo;
    private User $userModel;

    protected function setUp(): void
    {
        // Use in-memory SQLite for fast, zero-dependency unit tests
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE user (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                age INTEGER NOT NULL,
                job TEXT NOT NULL
            )
        ");

        $this->userModel = new User($this->pdo);
    }

    public function testCreateAndGetUser(): void
    {
        $created = $this->userModel->createUser('Alice', 25, 'Developer');
        $this->assertTrue($created);

        $user = $this->userModel->getUserByName('Alice');
        $this->assertNotNull($user);
        $this->assertEquals('Alice', $user['name']);
        $this->assertEquals(25, (int)$user['age']);
        $this->assertEquals('Developer', $user['job']);

        $userById = $this->userModel->getUserById((int)$user['id']);
        $this->assertNotNull($userById);
        $this->assertEquals('Alice', $userById['name']);
    }

    public function testGetAllUsers(): void
    {
        $this->userModel->createUser('Alice', 25, 'Developer');
        $this->userModel->createUser('Bob', 30, 'Designer');

        $users = $this->userModel->getAllUsers();
        $this->assertIsArray($users);
        $this->assertCount(2, $users);
    }

    public function testUpdateUserFields(): void
    {
        $this->userModel->createUser('Alice', 25, 'Developer');
        $user = $this->userModel->getUserByName('Alice');
        $id = (int)$user['id'];

        $this->userModel->updateUserName($id, 'Alice In Wonderland');
        $this->userModel->updateUserAge($id, 26);
        $this->userModel->updateUserJob($id, 'Tech Lead');

        $updated = $this->userModel->getUserById($id);
        $this->assertEquals('Alice In Wonderland', $updated['name']);
        $this->assertEquals(26, (int)$updated['age']);
        $this->assertEquals('Tech Lead', $updated['job']);
    }

    public function testDeleteUser(): void
    {
        $this->userModel->createUser('Alice', 25, 'Developer');
        $user = $this->userModel->getUserByName('Alice');
        $id = (int)$user['id'];

        $deleted = $this->userModel->deleteUserById($id);
        $this->assertTrue($deleted);

        $result = $this->userModel->getUserById($id);
        $this->assertNull($result);
    }
}
