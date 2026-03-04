# Flowgate

Flowgate is an API Rate Limiting and Analytics Platform built with Laravel.

Positioning: Stripe + Cloudflare-style API analytics for teams that want API key management, gateway enforcement, request telemetry, and usage insights in one backend.

## What It Does

- Creates and manages API keys per project
- Routes API traffic through a gateway endpoint
- Enforces per-key rate limits using Redis-compatible cache stores
- Logs request metadata for observability and reporting
- Aggregates hourly/daily analytics via background jobs
- Exposes analytics endpoints for dashboards

## Stack

- Laravel 12 (PHP 8.2+)
- Saloon v3 (upstream gateway HTTP client)
- Redis (recommended for rate limiting + analytics cache)
- MySQL/PostgreSQL/SQLite (local dev supported)
- Laravel Queues + Scheduler
- Optional Docker Compose runtime

## Implemented Features

### API Key Management

- Create keys (`POST /api/v1/keys`)
- List keys (`GET /api/v1/keys`)
- Rotate keys (`POST /api/v1/keys/{id}/rotate`)
- Revoke keys (`POST /api/v1/keys/{id}/revoke`)
- Secure storage: only key hash is persisted; plaintext key is returned once

### Gateway + Rate Limiting

- Gateway endpoint: `ANY /api/g/{project_slug}/{path?}`
- API key auth via `X-Api-Key` or Bearer token
- Policy-driven request-per-minute limits
- Upstream proxying implemented with Saloon connector/request classes
- Rate limit headers:
  - `X-RateLimit-Limit`
  - `X-RateLimit-Remaining`
  - `X-RateLimit-Reset`

### Laravel Best Practices Applied

- Form Request classes for request validation
- Json Resource classes for API response shaping
- Service classes for business logic and orchestration
- DTO-style data objects for key secret and proxy response payloads
- Queue jobs and console commands for async analytics processing

### Request Logging

Each gateway request captures:

- project + api key
- method + route
- status code
- latency
- request/response bytes
- client IP + user agent
- trace/request ID
- rate-limited flag

### Analytics

- Overview metrics (`GET /api/v1/analytics/overview`)
- Time series (`GET /api/v1/analytics/timeseries`)
- Top endpoints (`GET /api/v1/analytics/endpoints/top`)
- Hourly and daily aggregate tables for dashboard performance
- Cache-backed analytics responses

### Background Workers

Jobs implemented:

- `ProcessRequestLogJob`
- `AggregateUsageHourlyJob`
- `AggregateUsageDailyJob`
- `ExpireOldLogsJob`
- `WarmAnalyticsCacheJob`

Scheduled commands:

- `flowgate:aggregate-hourly` every 5 minutes
- `flowgate:aggregate-daily` daily 00:05
- `flowgate:expire-logs` daily 00:20
- `flowgate:warm-cache` every 10 minutes

## Architecture

1. Client sends request with API key to Flowgate gateway.
2. API key middleware validates active key for target project.
3. Rate limit middleware increments/checks counters in cache.
4. Allowed requests are proxied to the project upstream URL.
5. Request logs are persisted and post-processed asynchronously.
6. Aggregation workers roll up usage into hourly/daily buckets.
7. Analytics API reads aggregates and cache for fast dashboard queries.

## Data Model

Tables added:

- `projects`
- `rate_limit_policies`
- `api_keys`
- `request_logs`
- `usage_aggregates_hourly`
- `usage_aggregates_daily`

## Local Setup

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Run worker and scheduler in separate terminals:

```bash
php artisan queue:work
php artisan schedule:work
```

Run tests:

```bash
php artisan test
```

## Configuration

`FLOWGATE_*` settings (in `.env`):

- `FLOWGATE_ADMIN_TOKEN`
- `FLOWGATE_DEFAULT_HOURLY_LIMIT`
- `FLOWGATE_RATE_LIMIT_STORE`
- `FLOWGATE_ANALYTICS_CACHE_STORE`
- `FLOWGATE_ANALYTICS_CACHE_TTL_SECONDS`
- `FLOWGATE_REQUEST_LOG_RETENTION_DAYS`

Admin endpoints require:

- Header: `X-Admin-Token: <FLOWGATE_ADMIN_TOKEN>`

## API Quickstart

Create a project:

```bash
curl -X POST http://127.0.0.1:8000/api/v1/projects \
  -H "Content-Type: application/json" \
  -H "X-Admin-Token: change-me" \
  -d '{
    "name": "Primary API",
    "slug": "primary-api",
    "upstream_base_url": "https://httpbin.org"
  }'
```

Create a policy:

```bash
curl -X POST http://127.0.0.1:8000/api/v1/policies \
  -H "Content-Type: application/json" \
  -H "X-Admin-Token: change-me" \
  -d '{
    "project_id": 1,
    "name": "Starter",
    "requests_per_minute": 60,
    "requests_per_hour": 1000,
    "burst_limit": 120
  }'
```

Create an API key:

```bash
curl -X POST http://127.0.0.1:8000/api/v1/keys \
  -H "Content-Type: application/json" \
  -H "X-Admin-Token: change-me" \
  -d '{
    "project_id": 1,
    "rate_limit_policy_id": 1,
    "name": "Server Key"
  }'
```

Call gateway:

```bash
curl -X GET "http://127.0.0.1:8000/api/g/primary-api/get" \
  -H "X-Api-Key: fg_live_..."
```

## Optional Docker (Example)

Minimal services to include:

- `app` (Laravel PHP runtime)
- `nginx`
- `redis`
- `mysql` or `postgres`
- `queue-worker`

Then run standard startup + migration commands inside the app container.

## Project Quality Signals

- Feature tests cover key lifecycle and gateway rate limiting
- Existing auth/settings tests remain passing
- Clear separation of concerns: middleware, services, jobs, controllers
- Designed for extension into billing, alerts, RBAC, and multi-tenant plans

## Roadmap

- Sliding window / token bucket algorithms
- Dashboard frontend (charts + key drilldowns)
- Webhook alerts for threshold breaches
- Usage-based billing exports
- Team/org RBAC and API audit trail UI

## License

MIT
