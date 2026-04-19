# LearnFlow API

LearnFlow is a **Laravel 11 backend showcase project** for an internal **ATS + learning platform**.
It is intentionally built as a realistic product-style API for managing vacancies, candidates, interviews, test assignments, learning tracks, progress, comments, and activity history.

The repository is designed as a portfolio piece for a junior PHP / Laravel role, but the codebase is structured to read like a small, disciplined internal product service.

---

## Product positioning

LearnFlow combines two internal workflows:

1. **ATS flow** — vacancies, candidates, hiring stages, interview scheduling, comments, audit trail.
2. **Learning flow** — courses, modules, candidate enrollments, progress tracking, stage automation.

The application is backend-only and suitable for a SPA, admin panel, or external internal client.

---

## Stack

- **PHP 8.2+**
- Docker image includes `pdo_pgsql` and `pdo_sqlite` so PostgreSQL runtime and SQLite test suite work in the same container without a manual Dockerfile patch
- **Laravel 11**
- **Laravel Sanctum** for token auth
- **PostgreSQL** in Docker setup
- PHPUnit feature + unit tests
- Form Requests
- API Resources
- Policies / Gates
- Service layer for domain logic
- Docker + docker-compose
- Telegram notifier abstraction with safe local fallback

---

## Main capabilities

### Authentication
- `POST /api/login`
- `POST /api/logout`
- `GET /api/me`
- Bearer token auth with Sanctum

### Vacancies
- list / create / view / update / delete
- filtering by status / department / search
- sorting and pagination

### Candidates
- list / create / view / update
- search / filters / sorting / pagination
- vacancy / recruiter / mentor linkage
- explicit status transitions through domain rules
- candidate comments

### Interviews
- schedule / reschedule / cancel / complete / delete
- candidate + interviewer linkage
- interview scheduling moves candidate into `interview`

### Test assignments
- assign task to candidate
- update task details
- complete task
- candidate stage is automatically re-evaluated

### Learning
- manage courses
- manage modules
- assign courses to candidates
- update per-module progress
- auto-complete enrollments and re-evaluate candidate stage

### Auditability
- key domain actions are stored in `activity_logs`
- admin-only activity log access endpoint

---

## Roles and permissions

### `admin`
- unrestricted access through `Gate::before`
- can inspect activity logs

### `recruiter`
- manages vacancies
- manages candidates and candidate statuses
- schedules / completes interviews
- assigns and completes test tasks
- can read candidate progress

### `mentor`
- manages courses and modules
- assigns courses to candidates
- updates candidate progress
- can comment on candidates
- cannot create vacancies or schedule interviews

---

## Business rules implemented

The application enforces domain rules beyond CRUD:

1. **Rejected candidates cannot re-enter the pipeline.**
2. **Interview cannot be scheduled for rejected candidate.**
3. **Invalid candidate status transitions are rejected at the domain layer.**
4. **Candidate cannot become `ready_for_interview` while there are open test tasks or incomplete enrollments.**
5. **Assigning new mandatory work to a `ready_for_interview` candidate moves the candidate back to `learning` or `test_task`.**
6. **Candidate cannot become `hired` without at least one completed and passed interview.**
7. **Hired candidates are terminal for interview / task / course assignment flows.**
8. **Completing a test assignment automatically re-evaluates candidate stage.**
9. **Completing all required learning modules automatically re-evaluates candidate stage.**
10. **Operational next stage is derived from remaining mandatory work:**
   - incomplete course enrollments → `learning`
   - open test assignments → `test_task`
   - no remaining required work → `ready_for_interview`
11. **Moving candidate to `interview` triggers external notification.**
12. **Important actions are written to `activity_logs`.**

See also:
- [`docs/status-transitions.md`](docs/status-transitions.md)
- [`docs/er-diagram.md`](docs/er-diagram.md)
- [`docs/release-audit.md`](docs/release-audit.md)
- [`docs/local-acceptance-checklist.md`](docs/local-acceptance-checklist.md)
- [`docs/publish-decision.md`](docs/publish-decision.md)

---

## Architecture notes

The project intentionally avoids fake enterprise layers.

### Used intentionally
- **Controllers** for orchestration only
- **Form Requests** for validation
- **Policies / Gates** for authorization
- **API Resources** for consistent output
- **Services** for business workflows:
  - `CandidateStatusManager`
  - `InterviewService`
  - `TestAssignmentService`
  - `CourseProgressService`
  - `CandidateService`
  - `ActivityLogService`
- **Enums** for core states
- **Notifier abstraction** through `App\Contracts\ExternalNotifier`

### Not used intentionally
- no meaningless repository layer
- no business logic stuffed into controllers
- no decorative “empty architecture” files

---

## API response format

Every successful response follows a consistent envelope:

```json
{
  "success": true,
  "message": "Candidate created.",
  "data": {...},
  "meta": null
}
```

Pagination responses include:

```json
{
  "meta": {
    "pagination": {
      "current_page": 1,
      "last_page": 3,
      "per_page": 15,
      "total": 42
    }
  }
}
```

Validation, auth, authorization, business-rule, and not-found responses are returned as JSON envelopes as well.

---

## Project structure

```text
app/
  Contracts/
  Enums/
  Exceptions/
  Filters/
  Http/
    Controllers/Api/
    Requests/
    Resources/
  Models/
  Policies/
  Providers/
  Services/
database/
  factories/
  migrations/
  seeders/
docs/
  er-diagram.md
  openapi.yaml
  release-audit.md
  status-transitions.md
  local-acceptance-checklist.md
  publish-decision.md
scripts/
  verify-static.php
tests/
  Feature/
  Unit/
```

---

## Local setup with Docker

### 1. Copy environment

```bash
cp .env.example .env
```

### 2. Start services

```bash
docker compose up -d --build
```

The app container entrypoint will automatically run `composer install` on first boot if `vendor/` is missing.

### 3. Generate application key (first run)

```bash
docker compose exec app php artisan key:generate
```

### 4. Run migrations and seed demo data

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 5. Open the API

```text
http://localhost:8000
```

OpenAPI file is exposed at:

```text
http://localhost:8000/openapi.yaml
```

### Useful Docker commands

```bash
docker compose logs -f app
docker compose exec app php artisan test
docker compose exec app php scripts/verify-static.php
```

---

## Non-Docker setup

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Default DB connection in `.env.example` is PostgreSQL.
For local experiments or tests you can switch to SQLite.

---

## Demo users

Seeded credentials:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@learnflow.test` | `password` |
| Recruiter | `recruiter@learnflow.test` | `password` |
| Mentor | `mentor@learnflow.test` | `password` |

---

## Example API usage

### Login

```bash
curl --request POST \
  --url http://localhost:8000/api/login \
  --header 'Content-Type: application/json' \
  --data '{
    "email": "recruiter@learnflow.test",
    "password": "password",
    "device_name": "postman"
  }'
```

### Create candidate

```bash
curl --request POST \
  --url http://localhost:8000/api/v1/candidates \
  --header 'Authorization: Bearer YOUR_TOKEN' \
  --header 'Content-Type: application/json' \
  --data '{
    "first_name": "Anna",
    "last_name": "Smirnova",
    "email": "anna@example.test",
    "github_username": "anna-dev"
  }'
```

### Move candidate to screening

```bash
curl --request PATCH \
  --url http://localhost:8000/api/v1/candidates/1/status \
  --header 'Authorization: Bearer YOUR_TOKEN' \
  --header 'Content-Type: application/json' \
  --data '{
    "status": "screening",
    "screening_completed": true
  }'
```

---

## OpenAPI

The repository includes a hand-maintained OpenAPI contract:

- source: [`docs/openapi.yaml`](docs/openapi.yaml)
- public copy: [`public/openapi.yaml`](public/openapi.yaml)

---

## Telegram integration

LearnFlow includes a real external notifier abstraction.
By default it uses a safe local fallback that only writes to logs.

To enable Telegram notifications:

```env
TELEGRAM_ENABLED=true
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
TELEGRAM_TIMEOUT=5
```

Current trigger:
- candidate moved to `interview`

Implementation details:
- contract: `App\Contracts\ExternalNotifier`
- real implementation: `App\Services\Notifications\TelegramNotifier`
- fallback implementation: `App\Services\Notifications\NullNotifier`

This keeps local development safe while leaving the integration realistic.

---

## Testing

Run the test suite:

```bash
php artisan test
```

Test execution is wired to the SQLite testing environment from `phpunit.xml` and `.env.testing`, even though the main runtime uses PostgreSQL in Docker Compose.

or

```bash
vendor/bin/phpunit
```

Covered scenarios include:

- login / logout / current user
- unauthenticated access
- role-based access restrictions
- vacancy creation and recruiter-only access
- candidate creation and status transitions
- invalid status transition rejection
- interview scheduling
- rejected candidate interview restriction
- completing interview requires explicit result
- test task completion and automatic status update
- assigning new required work to a ready candidate rolls the stage back correctly
- course assignment and progress completion
- hired candidates cannot receive new interviews / tasks / courses
- preventing assignment of empty courses
- correct stage recalculation when learning and tasks overlap
- admin-only activity log access
- unit coverage for candidate status transition map

---

## Static verification

A lightweight repository audit script is included:

```bash
php scripts/verify-static.php
```

It validates:
- required project files
- JSON file integrity
- PHP syntax linting
- duplicate OpenAPI copies
- suspicious secret patterns
- unresolved `App\...` imports
- leftover TODO / FIXME markers

---

## Database design

The data model is relational and indexed for the main operational queries.

Included:
- foreign keys
- unique constraints
- soft deletes where appropriate
- explicit status fields
- audit table for key actions

See [`docs/er-diagram.md`](docs/er-diagram.md).

---

## GitHub-ready notes

This repository is intentionally shipped as **source code** and does **not** include the `vendor/` directory.
That is normal for Git repositories. Install dependencies before running the application.

The repo also intentionally does **not** contain real credentials, bot tokens, or `.env` secrets.

---

## Possible next steps

Natural follow-up improvements for a larger product:

- background queue processing for notifications
- email notification templates
- optimistic locking for highly concurrent updates
- richer reporting endpoints
- file uploads for CVs
- calendar integration for interview scheduling
- CI pipeline with Pint + PHPUnit + Larastan
