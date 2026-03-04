<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopEndpointResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'route' => (string) ($this->resource['route'] ?? ''),
            'total_requests' => (int) ($this->resource['total_requests'] ?? 0),
        ];
    }
}
