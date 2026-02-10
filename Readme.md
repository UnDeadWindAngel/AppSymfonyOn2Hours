# Product Catalog Service

Headless REST API service for managing products built with Symfony 6.4 and API Platform.

## Features

- CRUD operations for products via REST API
- JSON responses
- PostgreSQL for production, MySQL for testing
- Docker containerization
- API documentation with Swagger/OpenAPI

## Product Model

- `id` (integer, auto-increment)
- `name` (string, required, max 255 chars)
- `price` (decimal, required, positive)
- `status` (string, required, enum: "active"/"inactive", default: "active")
- `createdAt` (datetime, auto-set on creation)

## API Endpoints

- `GET /api/products` - List all products
- `GET /api/products/{id}` - Get a specific product
- `POST /api/products` - Create a new product
- `PATCH /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

## Quick Start

### Prerequisites

- Docker and Docker Compose
- Git

### Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd catalog-service
```

2. Start the services:
```bash
docker compose up -d --build
```

3. Wait for containers to start (about 30 seconds)

4. Apply database migrations:
```bash
docker exec catalog_php sh -c "php bin/console doctrine:migrations:migrate -n"
```

5. Access the application:
- API Documentation: http://localhost/api
- Products API: http://localhost/api/products

## Docker Services

- **nginx**: Web server on port 80
- **php**: PHP-FPM application server
- **postgres**: PostgreSQL database on port 5454
- **mysql**: MySQL database for testing on port 3310

## Environment Variables

Create `.env.local` to override:
- `DATABASE_URL`: PostgreSQL connection string
- `MYSQL_TEST_URL`: MySQL connection string for tests
- `APP_ENV`: Environment (dev/prod)

## API Examples

### Create a product
```bash
curl -X POST http://localhost/api/products \
  -H "Content-Type: application/json" \
  -d '{"name": "Laptop", "price": 999.99, "status": "active"}'
```
### List all products
```bash
curl http://localhost/api/products
```
### Get a specific product
```bash
curl http://localhost/api/products/1
```
### Update a product
```bash
curl -X PATCH http://localhost/api/products/1 \
  -H "Content-Type: application/merge-patch+json" \
  -d '{"price": 899.99}'
```
### Delete a product
```bash
curl -X DELETE http://localhost/api/products/1
```

## Running Tests

### Unit Tests
```bash
docker exec catalog_php sh -c "./vendor/bin/phpunit tests/Unit"
```
### Functional Tests (API via curl)
```bash
docker exec catalog_php sh -c "./vendor/bin/phpunit tests/Functional"
```
## Database Migrations

Create migration:
```bash
docker exec catalog_php sh -c "php bin/console make:migration"
```

Apply migrations:
```bash
docker exec catalog_php sh -c "php bin/console doctrine:migrations:migrate"
```

## Stopping Services

```bash
docker compose down
```

## Technologies Used

- Symfony 6.4
- API Platform 3.x
- Doctrine ORM
- PostgreSQL 15
- MySQL 8.0
- PHP 8.2
- Nginx
- Docker & Docker Compose

## Project Structure
```
catalog-service/
├── 📁 src/
│       ├── Entity/Product.php      # Product entity
│       └── Kernel.php              # Symfony kernel
├── 📁 config/                      # Configuration files
├── 📁 migrations/                  # Database migrations
├── 📁 tests/                       # Test files
│       ├── 📁 Unit/                # Unit tests
│       └── 📁 Functional/          # Functional tests
├── 📁 docker/                      # Docker configuration
├── 📁 public/                      # Web root
└── 📁 var/                         # Cache and logs
```
## License

MIT