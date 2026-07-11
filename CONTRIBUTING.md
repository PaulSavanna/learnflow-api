# Contributing

## Local Setup (Docker)

```bash
git clone https://github.com/PaulSavanna/learnflow-api
cd learnflow-api
cp .env.example .env
docker compose up --build -d
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

API is available at `http://localhost:8000`.

## Running Tests

Tests run against an in-memory SQLite database (configured in `.env.testing`):

```bash
# Inside Docker
docker compose exec app php artisan test

# Locally (requires PHP 8.3 + sqlite3)
php artisan test
```

## Code Style

```bash
./vendor/bin/pint        # auto-fix
./vendor/bin/pint --test # check without modifying
```

## Submitting Changes

1. Fork the repository
2. Create a branch: `git checkout -b feature/my-change`
3. Run `php artisan test` to make sure everything passes
4. Open a Pull Request
