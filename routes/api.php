<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\GatewayController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\RateLimitPolicyController;
use Illuminate\Support\Facades\Route;

Route::middleware('flowgate.correlation')->group(function (): void {
    Route::prefix('v1')->middleware(['flowgate.idempotency', 'flowgate.admin'])->group(function () {
        Route::apiResource('projects', ProjectController::class)->only(['index', 'store']);
        Route::apiResource('policies', RateLimitPolicyController::class)->only(['index', 'store']);

        Route::get('keys', [ApiKeyController::class, 'index']);
        Route::post('keys', [ApiKeyController::class, 'store']);
        Route::post('keys/{apiKey}/rotate', [ApiKeyController::class, 'rotate']);
        Route::post('keys/{apiKey}/revoke', [ApiKeyController::class, 'revoke']);

        Route::get('analytics/overview', [AnalyticsController::class, 'overview']);
        Route::get('analytics/timeseries', [AnalyticsController::class, 'timeseries']);
        Route::get('analytics/endpoints/top', [AnalyticsController::class, 'topEndpoints']);
    });

    Route::any('g/{project:slug}/{path?}', GatewayController::class)
        ->where('path', '.*')
        ->middleware(['flowgate.api_key', 'flowgate.rate_limit']);
});
