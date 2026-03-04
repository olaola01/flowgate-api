<?php

use App\Models\Flowgate\ApiKey;
use App\Models\Flowgate\Project;
use App\Models\Flowgate\RateLimitPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config()->set('flowgate.admin_token', 'test-admin-token');
    config()->set('flowgate.rate_limit_store', 'array');
});

afterEach(function (): void {
    MockClient::destroyGlobal();
});

it('creates and rotates API keys', function (): void {
    $project = Project::query()->create([
        'name' => 'Primary API',
        'slug' => 'primary-api',
        'upstream_base_url' => 'https://api.example.com',
        'is_active' => true,
    ]);

    $policy = RateLimitPolicy::query()->create([
        'project_id' => $project->id,
        'name' => 'Starter',
        'requests_per_minute' => 10,
        'requests_per_hour' => 100,
        'burst_limit' => 20,
        'is_active' => true,
    ]);

    $createResponse = $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->postJson('/api/v1/keys', [
            'project_id' => $project->id,
            'rate_limit_policy_id' => $policy->id,
            'name' => 'Server Key',
        ]);

    $createResponse
        ->assertCreated()
        ->assertJsonStructure(['data' => ['id', 'api_key', 'key_prefix']]);

    expect(ApiKey::query()->count())->toBe(1);

    $keyId = (int) $createResponse->json('data.id');

    $rotateResponse = $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->postJson('/api/v1/keys/'.$keyId.'/rotate');

    $rotateResponse
        ->assertOk()
        ->assertJsonStructure(['data' => ['id', 'api_key', 'key_prefix']]);
});

it('enforces rate limits on gateway requests', function (): void {
    MockClient::global([
        'https://api.example.com/*' => MockResponse::make(['ok' => true], 200),
    ]);

    $project = Project::query()->create([
        'name' => 'Primary API',
        'slug' => 'primary-api',
        'upstream_base_url' => 'https://api.example.com',
        'is_active' => true,
    ]);

    $policy = RateLimitPolicy::query()->create([
        'project_id' => $project->id,
        'name' => 'Strict',
        'requests_per_minute' => 2,
        'requests_per_hour' => 100,
        'burst_limit' => 2,
        'is_active' => true,
    ]);

    $createResponse = $this->withHeader('X-Admin-Token', 'test-admin-token')
        ->postJson('/api/v1/keys', [
            'project_id' => $project->id,
            'rate_limit_policy_id' => $policy->id,
            'name' => 'Gateway Key',
        ])
        ->assertCreated();

    $apiKey = $createResponse->json('data.api_key');

    $this->withHeader('X-Api-Key', $apiKey)
        ->getJson('/api/g/primary-api/customers')
        ->assertOk();

    $this->withHeader('X-Api-Key', $apiKey)
        ->getJson('/api/g/primary-api/customers')
        ->assertOk();

    $this->withHeader('X-Api-Key', $apiKey)
        ->getJson('/api/g/primary-api/customers')
        ->assertStatus(429)
        ->assertJson(['message' => 'Rate limit exceeded']);
});
