<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats endpoint ranking rows for analytics responses.
 */
class TopEndpointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, int|string>
     */
    public function toArray(Request $request): array
    {
        return [
            'route' => (string) ($this->resource['route'] ?? ''),
            'total_requests' => (int) ($this->resource['total_requests'] ?? 0),
        ];
    }
}
