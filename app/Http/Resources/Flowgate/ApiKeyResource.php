<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Flowgate\ApiKey */
class ApiKeyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'rate_limit_policy_id' => $this->rate_limit_policy_id,
            'name' => $this->name,
            'key_prefix' => $this->key_prefix,
            'status' => $this->status,
            'last_used_at' => $this->last_used_at,
            'expires_at' => $this->expires_at,
            'revoked_at' => $this->revoked_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'project' => ProjectResource::make($this->whenLoaded('project')),
            'policy' => RateLimitPolicyResource::make($this->whenLoaded('policy')),
        ];
    }
}
