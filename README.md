# Garden of Eden

<p align="center">
  A Laravel-based plant store for people who want to find plants, learn how to care for them, and make their spaces greener.
</p>

## Table of contents

- [About](#about)
- [Features](#features)
- [Usage](#usage)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Commands](#commands)
- [Architecture](#architecture)
- [Testing and quality](#testing-and-quality)
- [Build and deployment](#build-and-deployment)
- [CI/CD](#cicd)
- [Contributing](#contributing)
- [Branches](#branches)
- [FAQ](#faq)
- [Resources](#resources)
- [Gallery](#gallery)
- [Acknowledgments](#acknowledgments)
- [License](#license)
- [Dependencies](#dependencies)

## About

If you like plants, this is a place for you.

Garden of Eden is an online store where users can browse a varied catalog of plants and choose the ones they want to take home. Search and sorting options, such as date, price, and category, help visitors find a suitable plant. The application also provides guides for people who are new to plant care and want to understand how to treat their plants.

The project is a Laravel application developed for the **Special Topics in Software Engineering** course. Its current scope includes a plant catalog, categories, guides, user accounts, reviews, shopping carts, orders, reports, book recommendations, and an allied-products integration. It requires a persistent database and file storage; it is not a static-only site.

## Features

- Plant catalog with text search and sorting by date or price.
- Categories that group plants by purpose, environment, or care needs.
- Detailed plant, category, and care-guide pages.
- User registration, authentication, reviews, carts, and checkout.
- Order history with JSON and XLSX report downloads.
- Book recommendations and an allied-products API integration.
- Administration area for plants and guides.
- English and Spanish user interface.
- Docker-based local environment with PHP, Apache, and MySQL.

## Usage

1. Open the catalog and use the search field or sorting options to find plants.
2. Open a plant to review its price, stock, category, and care information.
3. Create an account to add plants to the cart, submit reviews, and complete purchases.
4. Visit **Guides** to learn about plant care, or **Books** for additional reading suggestions.

~~~text
Search for "fern" -> open a matching plant -> select a quantity -> add it to the cart -> sign in -> complete the order.
~~~

## Prerequisites

For the Docker workflow, install [Docker Desktop](https://www.docker.com/products/docker-desktop/).

For a local installation without Docker, install:

- PHP 8.2 or newer with gd, mbstring, pdo_mysql, and zip extensions.
- Composer 2.
- MySQL 8.0 or a compatible MySQL database.
- Node.js 18+ and npm when rebuilding front-end assets.

## Installation

Clone the repository:

~~~bash
git clone <repository-url>
cd PlantShop
~~~

### Docker (recommended)

**Windows PowerShell**

~~~powershell
Copy-Item .env.example .env
docker compose up --build -d
docker compose exec app php artisan db:seed
~~~

**macOS and Linux**

~~~bash
cp .env.example .env
docker compose up --build -d
docker compose exec app php artisan db:seed
~~~

Open [http://localhost:8080](http://localhost:8080).

### Local PHP installation

~~~bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
~~~

Configure the database variables in .env before running migrations. The local server is available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Configuration

Create .env from .env.example; do not commit .env, secrets, generated files, or local database files.

| Variable | Purpose | Required |
| --- | --- | --- |
| APP_KEY | Laravel encryption key. Generate it with php artisan key:generate. | Yes |
| APP_URL | Public URL used by Laravel to generate links. | Yes |
| DB_CONNECTION | Database driver; Docker uses mysql. | Yes |
| DB_HOST, DB_PORT | Database server location. | Yes |
| DB_DATABASE, DB_USERNAME, DB_PASSWORD | Database credentials. | Yes |
| PRODUCTS_API_URL | Allied-products API endpoint. | No |
| SUPABASE_URL | Supabase project URL, used for persistent media storage. | Vercel only |
| SUPABASE_SECRET_KEY | Server-only key used to upload and delete media. | Vercel only |
| SUPABASE_STORAGE_BUCKET | Public Supabase Storage bucket for plant and guide images. | Vercel only |

## Commands

| Goal | Command |
| --- | --- |
| Start Docker environment | docker compose up --build -d |
| Stop Docker environment | docker compose down |
| Reset and seed Docker database | docker compose exec app php artisan migrate:fresh --seed |
| Run tests | php artisan test |
| Check PHP coding style | ./vendor/bin/pint --test |
| Apply PHP coding style | ./vendor/bin/pint |
| Install front-end packages | npm install |
| Build front-end assets | npm run build |

## Architecture

~~~text
app/
  Http/Controllers/     HTTP request handling
  Models/               Eloquent domain entities
  Services/             Application workflows, including checkout
  Interfaces/           Contracts for external services and reports
  Util/                 Report and external API implementations
resources/views/        Blade layouts, reusable components, and pages
routes/                 Web, API, authentication, cart, and admin routes
database/seeders/       Development sample data
tests/                  Unit and feature tests
docker/                 Container entrypoint configuration
~~~

| Component | Responsibility |
| --- | --- |
| Controllers | Coordinate requests, validation, and view or response delivery. |
| Models | Represent plants, categories, guides, users, orders, items, and reviews. |
| CheckoutService | Handles the purchase transaction, inventory updates, and order creation. |
| Service providers | Bind report, book, and product-service contracts to their implementations. |
| Blade components | Keep public catalog cards, page headers, navigation, and footer reusable. |

## Testing and quality

The project includes unit and feature test suites configured in phpunit.xml. The test configuration uses an in-memory SQLite database:

~~~bash
php artisan test
~~~

Laravel Pint provides the PHP code-style check and formatter:

~~~bash
./vendor/bin/pint --test
./vendor/bin/pint
~~~

No coverage threshold or automated browser-test workflow is currently configured.

## Build and deployment

The repository includes a Dockerfile and compose.yaml for a reproducible local build. The application image uses PHP 8.2 with Apache, while MySQL 8.0 runs in a separate service.

~~~bash
docker compose up --build -d
docker compose exec app php artisan db:seed
~~~

The container entrypoint runs database migrations at startup. Confirm database connectivity and environment values before deployment. For production, use managed persistent storage for uploads, set APP_ENV=production, set APP_DEBUG=false, provide a unique APP_KEY, and run migrations as part of the release process.

### Vercel and Supabase

The repository includes api/index.php and vercel.json for the Vercel PHP community runtime. Before the first deployment:

1. Create a Supabase project and a **public** Storage bucket named plantshop, or choose another name and set SUPABASE_STORAGE_BUCKET.
2. In Vercel, configure DB_CONNECTION=pgsql and DATABASE_URL with the Supabase connection string. For serverless traffic, use the Supabase pooler connection.
3. Configure SESSION_DRIVER=database and CACHE_DRIVER=database.
4. Add SUPABASE_URL and SUPABASE_SECRET_KEY to Vercel. Never expose the secret key to the browser or commit it to Git.
5. Run the migrations against Supabase, including the sessions and cache migrations:

~~~bash
php artisan migrate --force
php artisan db:seed --force
~~~

When Supabase settings are present, new plant and guide images are uploaded to Supabase Storage. Without them, local development continues to use Laravel storage disks.

## CI/CD

No CI/CD workflow is currently committed in this repository. Before adding one, it should at minimum run php artisan test and ./vendor/bin/pint --test, with secrets configured in the selected CI provider instead of committed to the repository.

## Contributing

Contributions are welcome.

1. Report reproducible bugs with the expected and actual behavior.
2. Discuss significant features before implementing them.
3. Create a focused branch.
4. Add or update tests and documentation when behavior changes.
5. Run the test suite and style check before opening a pull request.

## Branches

No formal branch policy is currently documented in the repository. Agree on the target branch and merge strategy with the maintainers before opening a pull request.

## FAQ

### How do I reload the sample data?

Run docker compose exec app php artisan migrate:fresh --seed from the project directory. This removes existing local data and loads the development seeders again.

### Why is the allied-products page unavailable?

The page depends on the endpoint configured in PRODUCTS_API_URL. If that external service is unavailable, the application shows its fallback state.

### Do I need Node.js to run the app with Docker?

No. Node.js is only necessary when you change and rebuild front-end assets with Vite.

## Resources

- [Laravel documentation](https://laravel.com/docs/10.x)
- [Docker Compose documentation](https://docs.docker.com/compose/)
- [PHPUnit documentation](https://docs.phpunit.de/10.5/en/)

## Gallery

No maintained screenshots or demos are currently stored in the repository.

## Acknowledgments

- [Laravel](https://laravel.com/) and its open-source community.
- Bootstrap, Vite, and the PHP packages listed below.

## License

No project license file is currently included. Reuse permissions have not been declared by the repository maintainers.

## Dependencies

The following direct dependency constraints are maintained in composer.json and package.json. composer.lock resolves the full PHP dependency tree.

### PHP runtime

- dompdf/dompdf ^3.0
- guzzlehttp/guzzle ^7.2
- jwilsson/spotify-web-api-php ^6.0
- laravel/framework ^10.10
- laravel/sanctum ^3.3
- laravel/tinker ^2.8
- laravel/ui ^4.5
- phpoffice/phpspreadsheet ^2.1

### PHP development

- fakerphp/faker ^1.9.1
- laravel/pint ^1.0
- laravel/sail ^1.18
- mockery/mockery ^1.4.4
- nunomaduro/collision ^7.0
- phpunit/phpunit ^10.1
- spatie/laravel-ignition ^2.0

### Front-end development

- @popperjs/core ^2.11.6
- axios ^1.6.4
- bootstrap ^5.2.3
- laravel-vite-plugin ^1.0.0
- sass ^1.56.1
- vite ^5.0.0
