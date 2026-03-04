<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats a single timeseries analytics point.
 */
class AnalyticsTimeseriesPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, int|string|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'bucket_start' => $this->resource['bucket_start'] ?? null,
            'total_requests' => (int) ($this->resource['total_requests'] ?? 0),
            'blocked_requests' => (int) ($this->resource['blocked_requests'] ?? 0),
        ];
    }
}
