<?php

namespace App\Http\Resources\Flowgate;

use Illuminate\Http\Request;

/**
 * Extends API key responses with one-time plaintext secret values.
 */
class ApiKeyWithSecretResource extends ApiKeyResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     */
    public function __construct($resource, private readonly ?string $plainKey = null)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'api_key' => $this->plainKey,
        ]);
    }
}
