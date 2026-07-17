# Garden of Eden

Garden of Eden is a Laravel web application for discovering plants, browsing care guides, organizing plants by category, and managing a small shopping experience. It also includes book suggestions, an allied-products API integration, user accounts, reviews, carts, orders, and downloadable order reports.

## Features

- Plant catalog with search and sorting options.
- Category pages and plant detail pages.
- Plant care guides and external book recommendations.
- User registration, authentication, reviews, carts, and checkout.
- Order history with JSON and XLSX report downloads.
- Admin area for plant and guide management.
- English and Spanish interface.
- Docker-based local environment with PHP, Apache, and MySQL.

## Requirements

For the Docker workflow, only [Docker Desktop](https://www.docker.com/products/docker-desktop/) is required.

For a local installation without Docker, install:

- PHP 8.2 or newer with `gd`, `mbstring`, `pdo_mysql`, and `zip` extensions.
- Composer 2.
- MySQL 8.0 or a compatible MySQL database.
- Node.js 18+ and npm, only when rebuilding front-end assets.

## Run with Docker

1. Create the application environment file:

   ```bash
   cp .env.example .env
   ```

   On PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

2. Build and start the application:

   ```bash
   docker compose up --build -d
   ```

3. Load the development data:

   ```bash
   docker compose exec app php artisan db:seed
   ```

4. Open [http://localhost:8080](http://localhost:8080).

The container runs database migrations automatically when it starts. To reset the local database and load the seed data again, run:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

To stop the environment:

```bash
docker compose down
```

## Local installation

1. Install PHP dependencies and prepare the environment:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. Configure the `DB_*` variables in `.env` for your local MySQL database.

3. Create the database tables, seed sample content, and expose stored images:

   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

4. Start the server:

   ```bash
   php artisan serve
   ```

The application will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Configuration

Copy `.env.example` instead of committing `.env`. It contains environment-specific credentials and API settings.

The allied-products endpoint is configured through `PRODUCTS_API_URL`. Docker provides a default value, but it can be overridden in `.env` or in the shell before starting the containers.

## Useful commands

```bash
# Run the test suite
php artisan test

# Check coding style
./vendor/bin/pint --test

# Apply coding style fixes
./vendor/bin/pint

# Build front-end assets when they are changed
npm install
npm run build
```

## Dependencies

The version constraints below are maintained in `composer.json` and `package.json`. Run `composer install` and `npm install` to install the locked dependency tree.

### PHP runtime

- `dompdf/dompdf` `^3.0`
- `guzzlehttp/guzzle` `^7.2`
- `jwilsson/spotify-web-api-php` `^6.0`
- `laravel/framework` `^10.10`
- `laravel/sanctum` `^3.3`
- `laravel/tinker` `^2.8`
- `laravel/ui` `^4.5`
- `phpoffice/phpspreadsheet` `^2.1`

### PHP development

- `fakerphp/faker` `^1.9.1`
- `laravel/pint` `^1.0`
- `laravel/sail` `^1.18`
- `mockery/mockery` `^1.4.4`
- `nunomaduro/collision` `^7.0`
- `phpunit/phpunit` `^10.1`
- `spatie/laravel-ignition` `^2.0`

### Front-end development

- `@popperjs/core` `^2.11.6`
- `axios` `^1.6.4`
- `bootstrap` `^5.2.3`
- `laravel-vite-plugin` `^1.0.0`
- `sass` `^1.56.1`
- `vite` `^5.0.0`
