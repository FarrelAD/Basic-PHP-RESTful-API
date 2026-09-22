# Basic RESTful API in PHP

[![PR Check](https://github.com/FarrelAD/Basic-PHP-RESTful-API/actions/workflows/pr-check.yml/badge.svg)](https://github.com/FarrelAD/Basic-PHP-RESTful-API/actions/workflows/pr-check.yml)
[![Deploy](https://github.com/FarrelAD/Basic-PHP-RESTful-API/actions/workflows/deploy.yml/badge.svg)](https://github.com/FarrelAD/Basic-PHP-RESTful-API/actions/workflows/deploy.yml)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?logo=php)
![License](https://img.shields.io/badge/license-MIT-green)

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

---

## Developer Tools

This project ships three code-quality tools as `require-dev` dependencies, each accessible via a Composer shortcut:

| Tool | Command | Purpose |
|------|---------|---------|
| [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) | `composer lint` | Checks code against the **PSR-12** standard |
| [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) | `composer format` | Verifies formatting without writing (dry-run) |
| [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) | `composer format:fix` | Auto-fixes formatting issues in place |
| [PHPStan](https://phpstan.org/) | `composer analyse` | Static type analysis at **level 6** |

### Configuration files
- `phpcs.xml.dist` — PHP_CodeSniffer rules (PSR-12, targets `src/` and `public/`)
- `.php-cs-fixer.dist.php` — PHP CS Fixer rules (PSR-12 + strict types + import ordering)
- `phpstan.neon` — PHPStan settings (level 6, targets `src/`)

---

## CI/CD Pipeline

This project uses **GitHub Actions** with two separate, purpose-built workflows.

### 1. PR Check (`.github/workflows/pr-check.yml`)

Triggered automatically on every **Pull Request targeting `main`**. All jobs run in **parallel** on PHP 8.3:

```
PR → main
 ├── syntax-lint   php -l on all .php files
 ├── lint          phpcs (PSR-12)
 ├── format        php-cs-fixer --dry-run (no write)
 ├── analyse       phpstan (level 6)
 └── test          phpunit
```

All five checks must pass before a PR is considered safe to merge.

### 2. Deploy (`.github/workflows/deploy.yml`)

Triggered **manually only** via the GitHub Actions UI (`workflow_dispatch`). Inputs:

| Input | Options | Default |
|-------|---------|---------|
| `environment` | `staging` / `production` | `staging` |
| `skip_tests` | `true` / `false` | `false` |

Jobs run **sequentially**:

```
Manual trigger
 └── test     Full test suite + syntax check
      └── build    composer --no-dev --optimize-autoloader → ZIP artifact
           └── deploy   Upload artifact → deploy stub → smoke test stub
```

To wire up real deployment, edit the `deploy` step in `.github/workflows/deploy.yml` and add your secrets (SSH host, key, deploy path, etc.) to the GitHub repository's **Settings → Secrets and variables → Actions**.

**Required GitHub Secrets for Deployment:**
- `SSH_HOST`: The IP address or domain of your VPS.
- `SSH_USER`: The SSH username (e.g., `ubuntu` or `root`).
- `SSH_PRIVATE_KEY`: Your SSH private key for authentication.
- `DEPLOY_PATH`: The absolute path on your server where the app should be deployed (e.g., `/var/www/api`).
- `SSH_PORT`: (Optional) Custom SSH port, defaults to `22`.

The deployment uses a zero-downtime symlink approach:
- Releases are stored in `$DEPLOY_PATH/releases/<commit-hash>`
- A persistent environment file is kept at `$DEPLOY_PATH/shared/.env`
- The live site points to `$DEPLOY_PATH/current`

---

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

