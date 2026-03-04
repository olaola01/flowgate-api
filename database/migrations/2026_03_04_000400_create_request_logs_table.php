<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained()->nullOnDelete();
            $table->string('method', 16);
            $table->string('route', 1024);
            $table->unsignedSmallInteger('status_code')->index();
            $table->unsignedInteger('latency_ms')->default(0);
            $table->unsignedBigInteger('request_bytes')->default(0);
            $table->unsignedBigInteger('response_bytes')->default(0);
            $table->string('client_ip', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->string('trace_id', 128)->nullable()->index();
            $table->boolean('rate_limited')->default(false)->index();
            $table->timestamps();

            $table->index(['project_id', 'created_at']);
            $table->index(['api_key_id', 'created_at']);
            $table->index(['route', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
