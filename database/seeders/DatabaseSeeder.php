<?php

namespace Database\Seeders;

use App\Models\Flowgate\Project;
use App\Models\Flowgate\RateLimitPolicy;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $project = Project::query()->create([
            'name' => 'Demo API',
            'slug' => 'demo-api',
            'upstream_base_url' => 'https://httpbin.org',
            'is_active' => true,
        ]);

        RateLimitPolicy::query()->create([
            'project_id' => $project->id,
            'name' => 'Demo Policy',
            'requests_per_minute' => 60,
            'requests_per_hour' => 1000,
            'burst_limit' => 120,
            'is_active' => true,
        ]);
    }
}
