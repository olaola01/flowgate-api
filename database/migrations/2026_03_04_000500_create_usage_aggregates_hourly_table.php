<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usage_aggregates_hourly', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('bucket_start');
            $table->string('route', 1024);
            $table->string('method', 16);
            $table->unsignedBigInteger('total_requests')->default(0);
            $table->unsignedBigInteger('blocked_requests')->default(0);
            $table->unsignedBigInteger('error_requests')->default(0);
            $table->unsignedBigInteger('latency_sum_ms')->default(0);
            $table->unsignedInteger('latency_p95_ms')->default(0);
            $table->timestamps();

            $table->unique(['project_id', 'api_key_id', 'bucket_start', 'route', 'method'], 'usage_hourly_unique');
            $table->index(['project_id', 'bucket_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_aggregates_hourly');
    }
};
