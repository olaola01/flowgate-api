<?php

return [
    'admin_token' => env('FLOWGATE_ADMIN_TOKEN', 'change-me'),
    'default_hourly_limit' => (int) env('FLOWGATE_DEFAULT_HOURLY_LIMIT', 1000),
    'rate_limit_store' => env('FLOWGATE_RATE_LIMIT_STORE', env('CACHE_STORE', 'database')),
    'analytics_cache_store' => env('FLOWGATE_ANALYTICS_CACHE_STORE', env('CACHE_STORE', 'database')),
    'analytics_cache_ttl_seconds' => (int) env('FLOWGATE_ANALYTICS_CACHE_TTL_SECONDS', 60),
    'request_log_retention_days' => (int) env('FLOWGATE_REQUEST_LOG_RETENTION_DAYS', 30),
    'idempotency_ttl_seconds' => (int) env('FLOWGATE_IDEMPOTENCY_TTL_SECONDS', 86400),
    'correlation_id_header' => env('FLOWGATE_CORRELATION_ID_HEADER', 'X-Request-Id'),
];
