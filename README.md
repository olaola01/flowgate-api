# Flowgate

Flowgate is a production-style Laravel API gateway project focused on **API key management, rate limiting, telemetry, and analytics**.

It is designed as a portfolio-quality backend that demonstrates practical architecture decisions used in real systems:

- secure API key lifecycle
- cache-backed request throttling
- gateway proxying with Saloon
- structured request logging
- asynchronous analytics aggregation
- generated API documentation with Scribe

## Problem This Solves

Modern SaaS platforms often need an API gateway layer to control and observe API usage.

Typical challenges include:

• Managing API keys securely  
• Enforcing per-customer rate limits  
• Monitoring traffic patterns and errors  
• Understanding which endpoints drive the most usage  
• Providing analytics to internal teams or customers

Flowgate simulates a lightweight production API gateway that solves these operational problems while demonstrating backend architecture patterns used in real systems.

## Why This Project

Most API projects stop at CRUD. Flowgate adds the operational layer teams actually need in production:

- Who is calling my API?
- How much are they using?
- Are they exceeding limits?
- Which endpoints are hot/error-prone?
- Can I expose this data cleanly to customers/internal teams?

## Tech Stack

- **Framework:** Laravel 12
- **HTTP Integration:** Saloon v3
- **Cache/Rate limiting:** Redis (recommended)
- **Database:** MySQL / PostgreSQL / SQLite (dev)
- **Queue + Scheduling:** Laravel Queue + Scheduler
- **API Docs:** Laravel Scribe
- **Testing:** Pest + Laravel test utilities

## Architecture

- Architecture diagram: [docs/architecture.md](docs/architecture.md)

## Repository Structure

```text
app/
├── Actions/Fortify/                # auth actions
├── Concerns/                       # shared validation traits
├── Console/Commands/               # scheduled command entrypoints
├── Data/Flowgate/                  # DTOs
├── Http/
│   ├── Controllers/Api/            # Flowgate API endpoints
│   ├── Integrations/Flowgate/      # Saloon connector + requests
│   ├── Middleware/                 # admin key + gateway controls
│   ├── Requests/Api/               # Form Request validation
│   └── Resources/Flowgate/         # JsonResource transformers
├── Jobs/Flowgate/                  # async aggregation/log jobs
├── Models/Flowgate/                # domain models
├── Providers/                      # app + Fortify providers
└── Services/Flowgate/              # domain services

config/
├── flowgate.php
└── scribe.php

database/
├── migrations/
└── seeders/

docs/
└── architecture.md

routes/
├── api.php
└── console.php

tests/
├── Feature/
└── Unit/
```

High-level flow:

1. Client request enters gateway (`/api/g/{project}/{path?}`) with API key.
2. Middleware validates key and enforces rate limits.
3. Request is proxied to upstream with Saloon.
4. Telemetry is written to raw logs.
5. Background jobs aggregate logs to hourly/daily tables.
6. Analytics endpoints serve cached aggregate metrics.

## Core Features

### 1) Project Management

- Create/list upstream projects
- Store project slug + upstream base URL
- Enable/disable project traffic

### 2) API Key Management

- Create/list keys
- Rotate keys (returns new plaintext once)
- Revoke keys
- Hash-only key storage at rest

### 3) Rate Limiting

- Per-key policy-backed throttling
- Window-based Redis counters
- Standard response headers:
  - `X-RateLimit-Limit`
  - `X-RateLimit-Remaining`
  - `X-RateLimit-Reset`

### 4) Gateway Proxying

- Any HTTP method forwarding via Saloon connector/request
- Safe header forwarding
- Handles upstream failures cleanly

### 5) Telemetry + Analytics

- Raw `request_logs` table
- Hourly aggregates: `usage_aggregates_hourly`
- Daily aggregates: `usage_aggregates_daily`
- Overview, timeseries, top-endpoint analytics APIs

### 6) Async Processing

Jobs:

- `ProcessRequestLogJob`
- `AggregateUsageHourlyJob`
- `AggregateUsageDailyJob`
- `ExpireOldLogsJob`
- `WarmAnalyticsCacheJob`

Scheduled commands:

- `flowgate:aggregate-hourly` (every 5 min)
- `flowgate:aggregate-daily` (daily)
- `flowgate:expire-logs` (daily)
- `flowgate:warm-cache` (every 10 min)

## API Surface

### Management (`/api/v1/*`, requires `X-Admin-Token`)

- `GET /api/v1/projects`
- `POST /api/v1/projects`
- `GET /api/v1/policies`
- `POST /api/v1/policies`
- `GET /api/v1/keys`
- `POST /api/v1/keys`
- `POST /api/v1/keys/{apiKey}/rotate`
- `POST /api/v1/keys/{apiKey}/revoke`
- `GET /api/v1/analytics/overview`
- `GET /api/v1/analytics/timeseries`
- `GET /api/v1/analytics/endpoints/top`

### Gateway

- `ANY /api/g/{project_slug}/{path?}` (requires `X-Api-Key`)

## API Documentation (Scribe)

This project uses Scribe for generated docs.

Generate docs:

```bash
php artisan scribe:generate
```

Open docs at:

- `/docs` (HTML)
- `/docs.openapi` (OpenAPI)
- `/docs.postman` (Postman collection)

Scribe config:

- [config/scribe.php](config/scribe.php)

## Local Development

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Run app + worker + scheduler (separate terminals):

```bash
php artisan serve
php artisan queue:work
php artisan schedule:work
```

Run tests:

```bash
php artisan test
```

## Flowgate Configuration

Environment variables:

- `FLOWGATE_ADMIN_TOKEN`
- `FLOWGATE_DEFAULT_HOURLY_LIMIT`
- `FLOWGATE_RATE_LIMIT_STORE`
- `FLOWGATE_ANALYTICS_CACHE_STORE`
- `FLOWGATE_ANALYTICS_CACHE_TTL_SECONDS`
- `FLOWGATE_REQUEST_LOG_RETENTION_DAYS`

## Security Notes

- API keys are stored hashed (`sha256`) and compared safely.
- Plaintext key is returned only on creation/rotation.
- Management endpoints are protected by admin token middleware.
- Gateway strips sensitive inbound headers before upstream forwarding.

## Testing Coverage

Flowgate feature tests cover:

- API key creation/rotation
- rate limit enforcement behavior
- auth guard behavior on management routes
- analytics endpoint response structure and aggregation logic

See:

- [tests/Feature/FlowgateApiTest.php](tests/Feature/FlowgateApiTest.php)
- [tests/Feature/FlowgateManagementApiTest.php](tests/Feature/FlowgateManagementApiTest.php)

## Portfolio Highlights

This project demonstrates:

- clean API layering (Request classes + Resource classes)
- reusable domain services and DTOs
- async analytics pipeline design
- practical use of Saloon for external integration
- generated documentation workflow (Scribe)
- testable architecture with isolated feature tests

## Future Improvements

• Distributed rate limiting with sliding window algorithm  
• Multi-region Redis support  
• OpenTelemetry tracing integration  
• Dashboard UI for analytics visualization  
• Kafka / event streaming for log ingestion  
• Per-endpoint rate policies

## License

MIT
