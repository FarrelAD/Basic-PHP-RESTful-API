# Basic RESTful API in PHP

## Overview
This project is a RESTful API built in native PHP following modern PHP standards (PSR-4 autoloading with PascalCase namespace directories, PSR-12 coding standard, strict types, pure JSON REST conventions, and automated PHPUnit testing). It provides endpoints to manage user data, allowing clients to perform full CRUD (Create, Read, Update, Delete) operations using clean JSON payloads.

## Features

- **Standard PSR-4 Autoloading**: All application source code is consolidated inside `src/` under the `App\` namespace matching directory casing (`App\Config\`, `App\Controllers\`, `App\Models\`, `App\Routes\`, `App\Utils\`).
- **Reusable Utility Layer (`App\Utils`)**:
  - `Response::json()`: Standardized HTTP status codes, headers, and JSON encoding.
  - `Request::getJson()`: Secure JSON request parsing with fallback and mock testing support.
  - `Logger::error()`: Centralized error logging with absolute project path resolution.
- **Pure RESTful Architecture**: All requests and responses communicate using standard `application/json`.
- **Type Safety**: Enforces `declare(strict_types=1);` and scalar typing throughout models and controllers.
- **Automated Testing**: Comprehensive PHPUnit test suite covering utilities, database configuration, and model CRUD operations using in-memory SQLite (`:memory:`).

## API Endpoints

All request and response bodies use JSON (`Content-Type: application/json`).

### 1. Root / Welcome
- **Method**: `GET /`
- **Response**: `200 OK`
```json
{
    "status": "success",
    "message": "Welcome to Basic PHP RESTful API"
}
```

---

### 2. Get All Users
- **Method**: `GET /api/users`
- **Response**: `200 OK`
```json
{
    "status": "success",
    "message": "Successfully retrieved all users",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "age": 30,
            "job": "Software Engineer"
        }
    ]
}
```

---

### 3. Create User
- **Method**: `POST /api/users`
- **Headers**: `Content-Type: application/json`
- **Request Body**:
```json
{
    "name": "Alice Smith",
    "age": 28,
    "job": "Backend Developer"
}
```
- **Response**: `201 Created`
```json
{
    "status": "success",
    "message": "Successfully created user",
    "data": {
        "id": 2,
        "name": "Alice Smith",
        "age": 28,
        "job": "Backend Developer"
    }
}
```

---

### 4. Get User by ID
- **Method**: `GET /api/users/:id`
- **Response**: `200 OK`
```json
{
    "status": "success",
    "message": "Successfully retrieved user",
    "data": {
        "id": 1,
        "name": "John Doe",
        "age": 30,
        "job": "Software Engineer"
    }
}
```
- **Error Response**: `404 Not Found` if user does not exist.

---

### 5. Update User Data
- **Method**: `PATCH /api/users/:id`
- **Headers**: `Content-Type: application/json`
- **Request Body** (provide any combination of `name`, `age`, or `job`):
```json
{
    "job": "Lead Architect"
}
```
- **Response**: `200 OK`
```json
{
    "status": "success",
    "message": "Successfully updated user",
    "data": {
        "id": 1,
        "name": "John Doe",
        "age": 30,
        "job": "Lead Architect"
    }
}
```

---

### 6. Delete User by ID
- **Method**: `DELETE /api/users/:id`
- **Response**: `200 OK`
```json
{
    "status": "success",
    "message": "Successfully deleted user"
}
```

---

## Project Structure

```
.
├── public/
│   └── index.php             # Application Entry Point (Bootstrap & Routing)
├── src/
│   ├── Config/
│   │   └── Database.php      # App\Config\Database - PDO Connection Management
│   ├── Controllers/
│   │   └── UsersController.php # App\Controllers\UsersController - Request Handling
│   ├── Models/
│   │   └── User.php          # App\Models\User - Database CRUD Operations
│   ├── Routes/
│   │   └── api.php           # Route Matching & HTTP Method Dispatcher
│   └── Utils/
│       ├── Logger.php        # App\Utils\Logger - Centralized Error Logging
│       ├── Request.php       # App\Utils\Request - JSON Body Parser
│       └── Response.php      # App\Utils\Response - Standardized JSON Emitter
├── tests/
│   └── Unit/
│       ├── DatabaseTest.php  # Database configuration unit tests
│       ├── RequestTest.php   # Request parsing unit tests
│       ├── ResponseTest.php  # Response emitter unit tests
│       └── UserTest.php      # User model in-memory SQLite unit tests
├── .env.example              # Environment variables template
├── composer.json             # PSR-4 Autoload mappings & PHPUnit dependencies
├── phpunit.xml               # PHPUnit test suite configuration
└── README.md
```

---

## Getting Started

### Prerequisites
- PHP 7.4 or higher (PHP 8.x recommended)
- MySQL / MariaDB database
- Composer

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/FarrelAD/Basic-PHP-RESTful-API.git
   cd Basic-PHP-RESTful-API
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy environment configuration:
   ```bash
   cp .env.example .env
   ```
   Configure your database credentials in `.env`.

### Running Tests
Execute unit tests using Composer:
```bash
composer test
```
Or directly with PHPUnit:
```bash
vendor/bin/phpunit
```

### Running the Development Server
```bash
composer dev
```
The API will be available at `http://localhost:8000`.

## License
This project is open-source and available under the MIT License. Feel free to modify and use it as a learning resource.

## Star History

<a href="https://www.star-history.com/#FarrelAD/Basic-PHP-RESTful-API&type=date&legend=top-left">
 <picture>
   <source media="(prefers-color-scheme: dark)" srcset="https://api.star-history.com/svg?repos=FarrelAD/Basic-PHP-RESTful-API&type=date&theme=dark&legend=top-left" />
   <source media="(prefers-color-scheme: light)" srcset="https://api.star-history.com/svg?repos=FarrelAD/Basic-PHP-RESTful-API&type=date&legend=top-left" />
   <img alt="Star History Chart" src="https://api.star-history.com/svg?repos=FarrelAD/Basic-PHP-RESTful-API&type=date&legend=top-left" />
 </picture>
</a>

