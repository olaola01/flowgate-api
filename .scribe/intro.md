# Introduction

Flowgate is an API gateway for key management, rate limiting, request telemetry, and analytics.

<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>

    Use these endpoints to manage projects, issue API keys, enforce gateway rate limits, and query analytics.

    Authentication model:
    - Management endpoints (`/api/v1/*`) require `X-Admin-Token`.
    - Gateway endpoint (`/api/g/*`) requires `X-Api-Key` (or Bearer token).

