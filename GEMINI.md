# DhisProject (Lumen Portfolio)

A minimalist portfolio application built with the **Laravel Lumen** micro-framework. It features a project showcase with a modern, responsive design using Bootstrap 5.

## Project Overview

- **Architecture**: Micro-framework (Lumen 10) with Eloquent ORM and Blade templating.
- **Backend**: PHP 8.2 (Lumen Framework).
- **Frontend**: Blade, Bootstrap 5, FontAwesome 6, and custom JavaScript for interactive effects (typewriter).
- **Database**: MySQL 8.0 (stores project metadata).
- **Caching**: Redis 7.0 (integrated via `illuminate/redis`).
- **Containerization**: Dockerized setup with `app`, `db`, and `redis` services.

## Core Components

- **Routes**: Primary entry point is `/` in `routes/web.php`.
- **Models**: `App\Models\Project` (Schema: `id`, `title`, `description`, `preview`, `url`, `timestamps`).
- **Views**: 
    - `resources/views/layouts/app.blade.php`: Main layout.
    - `resources/views/index.blade.php`: Portfolio landing page with project listings.
- **Database**:
    - Migration: `database/migrations/2024_03_03_000000_create_projects_table.php`
    - Seeder: `database/seeders/ProjectSeeder.php`

## Building and Running

### Using Docker (Recommended)

The project includes a `docker-compose.yml` that orchestrates all services.

1.  **Start Services**:
    ```bash
    docker-compose up --build -d
    ```
    *Note: The `Dockerfile` includes an entrypoint script that automatically waits for MySQL, runs migrations, and seeds the database.*

2.  **Access the App**:
    Open `http://localhost:8000` in your browser.

### Manual Setup (Local Environment)

1.  **Install Dependencies**:
    ```bash
    composer install
    ```

2.  **Environment Setup**:
    ```bash
    cp .env.example .env
    # Configure your DB_*, REDIS_*, and other variables in .env
    ```

3.  **Database Migration & Seeding**:
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

4.  **Run Development Server**:
    ```bash
    php -S localhost:8000 -t public
    ```

## Development Conventions

- **Code Style**: Follows standard Laravel/Lumen PSR-12 conventions.
- **Models**: Business logic should reside in Models or Service layers (if expanded).
- **Routing**: Currently using closure-based routes for simplicity, but can be migrated to Controllers in `app/Http/Controllers`.
- **Testing**: PHPUnit tests are located in the `tests/` directory. Run tests using `./vendor/bin/phpunit`.

## Key Files

- `routes/web.php`: Application routes.
- `app/Models/Project.php`: Project Eloquent model.
- `resources/views/index.blade.php`: Main frontend template.
- `docker-compose.yml`: Infrastructure configuration.
- `Dockerfile`: Application container definition.
