# LearnFlow API

LearnFlow API is a Laravel-based backend project for managing a candidate hiring and learning workflow.

The project covers the full flow from vacancy creation and candidate processing to interviews, test assignments, courses, progress tracking, and activity logs.

## Project goal

This project was built as a backend portfolio project to demonstrate:

- REST API design
- role-based access control
- business logic for candidate status transitions
- Laravel testing
- Docker-based local setup
- database migrations and seeders

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

The system supports a hiring and learning pipeline where a candidate can move through stages such as:

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

## Local run

### 1. Clone the repository

```bash
git clone <your-repository-url>
cd LearnFlow
