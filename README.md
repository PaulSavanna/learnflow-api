# LearnFlow API

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-blue?logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![CI](https://github.com/PaulSavanna/learnflow-api/actions/workflows/ci.yml/badge.svg)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)

LearnFlow API is a Laravel-based backend project for managing a candidate hiring and learning workflow.

The system covers the full flow from vacancy creation and candidate processing to interviews, test assignments, courses, progress tracking, comments, and activity logs.

## Project goal

This project demonstrates:

- REST API design
- role-based access control
- business logic for candidate status transitions
- Laravel testing
- Docker-based local setup
- database migrations and seeders
- OpenAPI documentation

## Main features

- authentication with token-based access
- roles: admin, recruiter, mentor
- vacancy management
- candidate management
- candidate status transitions
- interview scheduling and result handling
- test assignment flow
- course assignment and progress tracking
- comments and activity logs
- OpenAPI documentation

## Candidate flow

A candidate can move through stages such as:

- new
- screening
- learning
- test task
- ready for interview
- interview
- hired
- rejected

The backend validates allowed status transitions and rejects invalid business actions.

## Tech stack

- PHP 8.3
- Laravel 11
- PostgreSQL
- Docker / Docker Compose
- PHPUnit

## Quick start

### 1. Clone the repository

```bash
git clone https://github.com/PaulSavanna/learnflow-api.git
cd learnflow-api
```

### 2. Copy environment file

```bash
cp .env.example .env
```

### 3. Start Docker containers

```bash
docker compose up --build -d
```

### 4. Install PHP dependencies

```bash
docker compose exec app composer install
```

### 5. Generate application key

```bash
docker compose exec app php artisan key:generate
```

### 6. Run database migrations and seeders

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Run tests

```bash
docker compose exec app php artisan test
```

## API documentation

The project includes OpenAPI documentation for the main endpoints.

## Example responsibilities of the system

- manage vacancies and candidates
- track candidate progress through the pipeline
- assign courses and test tasks
- schedule interviews
- store comments and activity history
- enforce valid business transitions

## Why this repository is useful

This project is designed as a backend portfolio piece that shows practical work with:

- Laravel architecture
- business rules
- relational database design
- API development
- testable backend code
- containerized local setup
