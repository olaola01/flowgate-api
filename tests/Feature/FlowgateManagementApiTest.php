<?php

use App\Models\Flowgate\Project;
use App\Models\Flowgate\UsageAggregateHourly;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config()->set('flowgate.admin_token', 'test-admin-token');
    config()->set('flowgate.analytics_cache_store', 'array');
    config()->set('flowgate.rate_limit_store', 'array');
});

it('requires admin token for management endpoints', function (): void {
    $this->getJson('/api/v1/projects')
        ->assertUnauthorized()
        ->assertJson(['message' => 'Unauthorized']);
});

it('creates projects and policies through management endpoints', function (): void {
    $projectResponse = $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->postJson('/api/v1/projects', [
            'name' => 'Primary API',
            'slug' => 'primary-api',
            'upstream_base_url' => 'https://api.example.com',
            'is_active' => true,
        ])
        ->assertCreated();

    $projectId = (int) $projectResponse->json('data.id');

    $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->postJson('/api/v1/policies', [
            'project_id' => $projectId,
            'name' => 'Starter',
            'requests_per_minute' => 60,
            'requests_per_hour' => 1000,
            'burst_limit' => 120,
            'is_active' => true,
        ])
        ->assertCreated()
        ->assertJsonPath('data.project_id', $projectId)
        ->assertJsonPath('data.name', 'Starter');
});

it('returns aggregated analytics payloads', function (): void {
    $project = Project::query()->create([
        'name' => 'Primary API',
        'slug' => 'primary-api',
        'upstream_base_url' => 'https://api.example.com',
        'is_active' => true,
    ]);

    UsageAggregateHourly::query()->create([
        'project_id' => $project->id,
        'api_key_id' => null,
        'bucket_start' => now()->subHour()->startOfHour(),
        'route' => '/api/g/primary-api/customers',
        'method' => 'GET',
        'total_requests' => 100,
        'blocked_requests' => 10,
        'error_requests' => 5,
        'latency_sum_ms' => 8000,
        'latency_p95_ms' => 220,
    ]);

    $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->getJson('/api/v1/analytics/overview?project_id='.$project->id)
        ->assertOk()
        ->assertJsonPath('data.total_requests', 100)
        ->assertJsonPath('data.blocked_requests', 10);

    $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->getJson('/api/v1/analytics/timeseries?project_id='.$project->id)
        ->assertOk()
        ->assertJsonStructure(['data' => [['bucket_start', 'total_requests', 'blocked_requests']]]);

    $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->getJson('/api/v1/analytics/endpoints/top?project_id='.$project->id.'&limit=5')
        ->assertOk()
        ->assertJsonPath('data.0.route', '/api/g/primary-api/customers')
        ->assertJsonPath('data.0.total_requests', 100);
});

it('replays mutating management requests with idempotency keys', function (): void {
    $payload = [
        'name' => 'Idempotent Project',
        'slug' => 'idempotent-project',
        'upstream_base_url' => 'https://api.example.com',
        'is_active' => true,
    ];

    $first = $this->withHeaders([
        'X-Admin-Token' => 'test-admin-token',
        'Idempotency-Key' => 'idem-project-create-1',
    ])->postJson('/api/v1/projects', $payload)->assertCreated();

    $second = $this->withHeaders([
        'X-Admin-Token' => 'test-admin-token',
        'Idempotency-Key' => 'idem-project-create-1',
    ])->postJson('/api/v1/projects', $payload)->assertCreated();

    expect(Project::query()->where('slug', 'idempotent-project')->count())->toBe(1);
    expect($first->json('data.id'))->toBe($second->json('data.id'));
    $second->assertHeader('X-Idempotency-Status', 'replayed');
});

it('adds and propagates correlation ids in API responses', function (): void {
    $generated = $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->getJson('/api/v1/projects')
        ->assertOk();

    expect($generated->headers->get('X-Request-Id'))->not->toBeNull();

    $providedId = 'corr-test-id-123';
    $echoed = $this->withHeaders([
        'X-Admin-Token' => 'test-admin-token',
        'X-Request-Id' => $providedId,
    ])->getJson('/api/v1/projects')->assertOk();

    $echoed->assertHeader('X-Request-Id', $providedId);
});
