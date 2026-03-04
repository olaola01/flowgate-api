<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats rate limit policy records for API responses.
 *
 * @mixin \App\Models\Flowgate\RateLimitPolicy
 */
class RateLimitPolicyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, bool|int|string|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'name' => $this->name,
            'requests_per_minute' => $this->requests_per_minute,
            'requests_per_hour' => $this->requests_per_hour,
            'burst_limit' => $this->burst_limit,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
