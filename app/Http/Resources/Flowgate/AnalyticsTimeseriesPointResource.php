<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsTimeseriesPointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'bucket_start' => $this->resource['bucket_start'] ?? null,
            'total_requests' => (int) ($this->resource['total_requests'] ?? 0),
            'blocked_requests' => (int) ($this->resource['blocked_requests'] ?? 0),
        ];
    }
}
