<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsOverviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_requests' => (int) ($this->resource['total_requests'] ?? 0),
            'blocked_requests' => (int) ($this->resource['blocked_requests'] ?? 0),
            'error_requests' => (int) ($this->resource['error_requests'] ?? 0),
            'error_rate' => (float) ($this->resource['error_rate'] ?? 0),
            'avg_latency_ms' => (float) ($this->resource['avg_latency_ms'] ?? 0),
        ];
    }
}
